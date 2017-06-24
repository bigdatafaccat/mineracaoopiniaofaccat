const express = require('express');
const bodyParser = require('body-parser');

const users = require('./routes/users');
const status = require('./routes/status');

const app = express();

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: false}));

app.use('/api/users', users);

app.use('/api', status);

app.listen(3000, () => console.log('Running on localhost:3000'));
