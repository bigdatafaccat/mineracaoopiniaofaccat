const express = require('express');
const mongoose = require('mongoose');
const path = require('path');
const config = require('../db');

mongoose.Promise = Promise;

const mongoConnect = () => {
  mongoose.connect(config.db.mongo, (err, res) => {
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

const anySchema = new mongoose.Schema({}, { strict: false });
const PostModel = mongoose.model('posts', anySchema);

router.get('/', (req, res) => {
  PostModel.find({}).exec(function (err, posts) {
    const postsJSON = posts.map((post) => {
      return post.toJSON();
    });

    res.send({ data: postsJSON });
  });
});

router.get('/pretty', (req, res) => {
  PostModel.find({}).exec(function (err, posts) {
    const postsJSON = posts.map((post) => {
      return post.toJSON();
    });

    res.render("index", { data: postsJSON });
  });
});

router.post('/', (req, res) => {
  var post = new PostModel(req.body);

  post.save((err) => {
    if (err) {
      return res.sendStatus(500).send(err.message);
    } else {
      return res.sendStatus(200);
    }
  });
});

router.delete('/', (req, res) => {
  PostModel.remove({ _id: req.body.id }, (err) => {
    if (err) {
      res.sendStatus(500).send(err.message);
    } else {
      res.sendStatus(200);
    }
  });
});

router.delete('/deleteAll', (req, res) => {
  PostModel.remove({}, (err) => {
    if (err) {
      res.sendStatus(500).send(err.message);
    } else {
      res.sendStatus(200);
    }
  });
});

module.exports = router;