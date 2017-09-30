const mongoose = require('mongoose');

const anySchema = new mongoose.Schema({}, { strict: false });
const PostModel = mongoose.model('posts', anySchema);

module.exports = PostModel;