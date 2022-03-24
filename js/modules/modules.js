import { useModal } from "./modal.js";
import { usePreviewImages } from "./previewImages.js";
import { useCount } from "./count.js";
import { useTweetsOpt, useTweetsReacts } from "./tweetsBtns.js";
import { useExplore } from "./explore.js";


useModal();
useCount();
usePreviewImages();
useTweetsOpt();
useTweetsReacts();
useExplore();

