const calculate = posts => {
    const data = calculateAmounts(posts);

    calculateCommentsMean(data);
    calculateReactionsMean(data);
    calculatePeopleInvolved(data);

    return data;
};

const calculateMedian = posts => {
    // TODO
};

const calculatePeopleInvolved = data => {
    for (const group in data) {
        data[group].peopleInvolved = [...new Set(data[group].peopleInvolved)].length;
    }
};

const calculateCommentsMean = data => {
    for (const group in data) {
        const posts = data[group].posts;
        const comments = data[group].comments;

        data[group].commentsMean = comments / posts;
    }
};

const calculateReactionsMean = data => {
    for (const group in data) {
        const posts = data[group].posts;
        const reactions = data[group].reactions;

        data[group].WOW_Mean = reactions.WOW / posts;
        data[group].SAD_Mean = reactions.SAD / posts;
        data[group].LIKE_Mean = reactions.LIKE / posts;
        data[group].ANGRY_Mean = reactions.ANGRY / posts;
        data[group].LOVE_Mean = reactions.LOVE / posts;
        data[group].HAHA_Mean = reactions.HAHA / posts;
        data[group].PRIDE_Mean = reactions.PRIDE / posts;
    }
};

const calculateAmounts = posts => {
    const data = {};
    const peopleInvolved = {};

    posts.map(postSaved => {
        const post = postSaved.toJSON();

        const groupName = post.target.name;

        data[groupName] = data[groupName] || defaultStructure();
        data[groupName].posts += 1;
        data[groupName].peopleInvolved.push(post.from.id);

        // Reações do post
        if (post.reactions && post.reactions.data) {
            post.reactions.data.map(reaction => {
                data[groupName].reactions[reaction.type] += 1;
                data[groupName].peopleInvolved.push(reaction.id);
            });
        }

        // Commentários do post
        if (!post.comments || !post.comments.data) {
            return;
        }

        post.comments.data.map(comment => {
            data[groupName].comments += comment.comment_count + 1;

            if (!comment.comments || !comment.comments.data) {
                return;
            }

            comment.comments.data.map(commentOfComment => {
                // Comentário do comentário
                data[groupName].comments += 1;
                data[groupName].peopleInvolved.push(commentOfComment.from.id);

                if (!commentOfComment.reactions) {
                    return;
                }

                // Reações do cometário do comentário
                commentOfComment.reactions.data.map(reaction => {
                    data[groupName].reactions[reaction.type] += 1;
                    data[groupName].peopleInvolved.push(reaction.id);
                });
            });
        });
    });

    return data;
};

const defaultStructure = () => {
    return {
        posts: 0,
        comments: 0,
        peopleInvolved: [],
        reactions: {
            WOW: 0,
            SAD: 0,
            LIKE: 0,
            ANGRY: 0,
            LOVE: 0,
            HAHA: 0,
            PRIDE: 0 /* Pride é uma bandeira listrada colorida */
        }
    };
};

module.exports = { calculate }