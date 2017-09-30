const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');

const preprocessing = require('./routes/preprocessing');
const posts = require('./routes/posts');
const status = require('./routes/status');

const app = express();

app.set("view engine", "pug");
app.set("views", path.join(__dirname, "views"));

app.use(bodyParser.json({ limit: '50mb' }));
app.use(bodyParser.urlencoded({ limit: '50mb', extended: true }));

app.use('/api/preprocessing', preprocessing);
app.use('/api/posts', posts);
app.use('/api', status);

app.listen(3000, () => console.log('Running on localhost:3000'));
