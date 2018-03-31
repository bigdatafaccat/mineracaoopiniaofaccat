const express = require('express');
const mongoose = require('mongoose');
const path = require('path');
const config = require('../db');

const statisticsService = require('../services/statisticsService');
const PostModel = require('../models/post.js');

mongoose.Promise = Promise;

const mongoConnect = () => {
  mongoose.connection.openUri(config.db.mongo, (err, res) => {
    if (err) {
      console.log('Failed: ' + err);
    } else {
      console.log('Connected: ' + config.db.mongo);
    }
  });
};

mongoose.connection.on('error', console.log);
mongoose.connection.on('disconnected', mongoConnect);

mongoConnect();

const router = express.Router();

router.get('/', (req, res) => {
  PostModel.find({}).exec((err, posts) => {
    const postsJSON = posts.map((post) => {
      return post.toJSON();
    });

    return res.send({ data: postsJSON });
  });
});

router.get('/unique/:id', (req, res) => {
  const postId = req.params.id

  PostModel.findOne({ post_id: postId }, (err, postSaved) => {
    const post = postSaved.toObject()

    return res.send({ data: post });
  });
});

router.get('/pieces', (req, res) => {
  let filter = {};

  if (Object.keys(req.query).length !== 0) {
    filter = {
      "created_time": {
        "$gte": req.query.startdate,
        "$lte": req.query.enddate
      }
    };
  }

  PostModel.find(filter).exec((err, posts) => {
    const postsJSON = posts.map((post) => {
      return post.toJSON();
    });

    return res.send({ data: postsJSON });
  });
});

router.get('/pretty', (req, res) => {
  PostModel.find({}).exec((err, posts) => {
    const postsJSON = posts.map((post) => {
      return post.toJSON();
    });

    return res.render("index", { data: postsJSON });
  });
});

router.get('/statistics', (req, res) => {
  let filter = {};

  if (Object.keys(req.query).length !== 0) {
    filter = {
      "created_time": {
        "$gte": req.query.startdate,
        "$lt": req.query.enddate
      }
    };
  }

  PostModel.find(filter).exec((err, posts) => {
    const data = statisticsService.calculate(posts);

    return res.send({ data });
  });
});

router.post('/', (req, res) => {
  const postId = req.body.id;

  const post = new PostModel(req.body);

  post.set("post_id", postId);

  PostModel.findOne({ post_id: postId }, (err, postSaved) => {
    if (postSaved) {
      return res.sendStatus(200);
    }

    post.save((err) => {
      if (err) {
        return res.sendStatus(500).send(err.message);
      } else {
        return res.sendStatus(200);
      }
    });
  });
});

router.delete('/', (req, res) => {
  PostModel.remove({ _id: req.body.id }, (err) => {
    if (err) {
      return res.sendStatus(500).send(err.message);
    } else {
      return res.sendStatus(200);
    }
  });
});

router.delete('/deleteAll', (req, res) => {
  PostModel.remove({}, (err) => {
    if (err) {
      return res.sendStatus(500).send(err.message);
    } else {
      return res.sendStatus(200);
    }
  });
});

module.exports = router;