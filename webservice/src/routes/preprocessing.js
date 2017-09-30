const express = require('express');
const PostModel = require('../models/post.js')

const router = express.Router();

router.get('/fase1', (req, res) => {
  PostModel.find({}).exec((err, posts) => {
    posts.map((post) => {
      const postJSON = post.toJSON();

      let messageDescription = '';

      if (postJSON.message) {
        messageDescription = postJSON.message;
      }

      if (postJSON.description) {
        messageDescription += (messageDescription ? '_' : '') + postJSON.description;
      }

      post.set("message_description", messageDescription);

      post.save(err => {
        if (err) console.log(err)
      });
    });

    return res.sendStatus(200);
  });
});

module.exports = router;