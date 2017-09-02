const calculate = posts => {
    const data = calculateAmounts(posts);

    const result = {};

    for (const group in data) {
        result[group] = defaultResultStructure();
    }

    calculateCommentsMean(data, result);
    calculateReactionsMean(data, result);
    calculatePeopleInvolved(data, result);
    calculateCommentsMedian(data, result);
    calculateReactionsMedian(data, result);

    return result;
};

const calculateCommentsMedian = (data, result) => {
    for (const group in data) {
        const list = [];

        data[group].map(x => {
            list.push(x.comments);
        });

        result[group].commentsMedian = calculateMedian(list);
    }
};

const calculateReactionsMedian = (data, result) => {
    for (const group in data) {
        const list = [];

        data[group].map(x => {
            list.push(x.reactions);
        });

        result[group].reactionsMedian = calculateMedian(list);
    }
};

const calculateMedian = list => {
    list = list.sort(function (a, b) { return a - b; });

    const i = list.length / 2;

    return i % 1 === 0 ? (list[i - 1] + list[i]) / 2 : list[Math.floor(i)];
};

const calculatePeopleInvolved = (data, result) => {
    for (const group in data) {
        const peopleInvolved = [];

        data[group].map(x => {
            x.peopleInvolved.map(person => {
                peopleInvolved.push(person)
            });
        });

        result[group].peopleInvolved = [...new Set(peopleInvolved)].length;
    }
};

const calculateCommentsMean = (data, result) => {
    for (const group in data) {
        data[group].map(x => {
            result[group].postsAmount += 1;
            result[group].commentsAmount += x.comments;
        });

        result[group].commentsMean = result[group].commentsAmount / result[group].postsAmount;
    }
};

const calculateReactionsMean = (data, result) => {
    for (const group in data) {
        for (const group in data) {
            data[group].map(x => {
                result[group].reactionsAmount += x.reactions;
            });

            result[group].reactionsMean = result[group].reactionsAmount / result[group].postsAmount;
        }
    }
};

const calculateAmounts = posts => {
    const data = {};
    const peopleInvolved = {};

    posts.map(postSaved => {
        const post = postSaved.toJSON();

        const groupName = post.target.name;

        data[groupName] = data[groupName] || [];

        const currentPost = defaultPostStructure();

        data[groupName].push(currentPost);

        currentPost.peopleInvolved.push(post.from.id);

        // Reações do post
        if (post.reactions && post.reactions.data) {
            post.reactions.data.map(reaction => {
                currentPost.reactions += 1;
                currentPost.peopleInvolved.push(reaction.id);
            });
        }

        // Commentários do post
        if (!post.comments || !post.comments.data) {
            return;
        }

        post.comments.data.map(comment => {
            currentPost.comments += comment.comment_count + 1;

            if (!comment.comments || !comment.comments.data) {
                return;
            }

            comment.comments.data.map(commentOfComment => {
                // Comentário do comentário
                currentPost.comments += 1;
                currentPost.peopleInvolved.push(commentOfComment.from.id);

                if (!commentOfComment.reactions) {
                    return;
                }

                // Reações do cometário do comentário
                commentOfComment.reactions.data.map(reaction => {
                    currentPost.reactions += 1;
                    currentPost.peopleInvolved.push(reaction.id);
                });
            });
        });
    });

    return data;
};

const defaultResultStructure = () => {
    return {
        postsAmount: 0,
        commentsAmount: 0,
        commentsMean: 0,
        commentsMedian: 0,
        reactionsAmount: 0,
        reactionsMean: 0,
        reactionsMedian: 0,
        peopleInvolved: 0
    };
};

const defaultPostStructure = () => {
    return {
        comments: 0,
        reactions: 0,
        peopleInvolved: []
    }
};

module.exports = { calculate }