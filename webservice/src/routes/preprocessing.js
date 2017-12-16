const express = require('express');
const PostModel = require('../models/post.js')

const router = express.Router();

router.get('/fase1', (req, res) => {
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
    posts.map((post) => {
      const postJSON = post.toJSON();

      let messageDescription = '';

      if (postJSON.message) {
        messageDescription = postJSON.message;
      }

      if (postJSON.description) {
        messageDescription += (messageDescription ? '. ' : '') + postJSON.description;
      }

      post.set("message_description", messageDescription);

      post.save(err => {
        if (err) {
          console.log(err)
        }
      });
    });

    return res.sendStatus(200);
  });
});

router.post('/fase2', (req, res) => {
  const postId = req.body.post_id

  PostModel.findOne({ post_id: postId }, (err, postSaved) => {
    postSaved.set('words_tagged', req.body.words_tagged);
    postSaved.set('sentences', req.body.sentences);

    let post = postSaved.toObject()

    // Se existe algum comentário para esse post
    if (req.body.comments.length > 0) {

      req.body.comments.map(comment => {
        let commentSaved = post.comments.data.find(x => x.id == comment.id)

        commentSaved.comment_tagged = comment.comment_tagged
        commentSaved.comment_sentences = comment.comment_sentences
      });
    }

    PostModel.update({ post_id: postId }, post, function (err) {
      if (err) {
        return res.sendStatus(500).send(err.message);
      } else {
        return res.sendStatus(200);
      }
    });
  });
});

module.exports = router;