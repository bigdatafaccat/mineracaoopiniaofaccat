let express = require('express');
let mongoose = require('mongoose');
let path = require('path');
let config = require('../db');

mongoose.Promise = Promise;

let mongoConnect = () => {
  mongoose.connect(config.db.mongo, function (err, res) {
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

let router = express.Router();

let anySchema = new mongoose.Schema({ any: {} }, { strict: false });  
let PersonModel = mongoose.model('person', anySchema);

router.get('/', (req, res) => {
  PersonModel.find((err, data) => {
    if (err) {
      return res.sendStatus(500).send(err.message);
    } else {
      return res.send(data);
    }
  });
});

router.post('/', (req, res) => {
  var person = new PersonModel(req.body);

  person.save((err) => {
    if (err) {
      return res.sendStatus(500).send(err.message);
    } else {
      return res.sendStatus(200);
    }
  });
});

router.delete('/', (req, res) => {
  PersonModel.remove({ _id: req.body.id }, (err) => {
    if (err) {
      res.sendStatus(500).send(err.message);
    } else {
      res.sendStatus(200);
    }
  });
});

router.delete('/deleteAll', (req, res) => {
  PersonModel.remove({}, (err) => {
    if (err) {
      res.sendStatus(500).send(err.message);
    } else {
      res.sendStatus(200);
    }
  });
});

module.exports = router;