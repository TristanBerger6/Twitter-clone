import { usePostComment } from "./modules/postComment.js";
import { useQuoteTweet } from "./modules/quoteTweet.js";
import { useDeleteTweet } from "./modules/deleteTweet.js";
import { useRetweet } from "./modules/retweet.js";
import { useLike } from "./modules/like.js";
import { useFollow } from "./modules/follow.js";
import { useTweetsOpt, useTweetsReacts } from "./modules/tweetsBtns.js";

usePostComment();
useQuoteTweet();
useDeleteTweet();
useRetweet();
useLike();

useFollow();
useTweetsOpt();
useTweetsReacts();