-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 07, 2019 at 06:18 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biohomie`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `discussion_ID` int(11) NOT NULL,
  `comments` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_ID`, `user_ID`, `discussion_ID`, `comments`, `date_created`) VALUES
(9, 23, 18, 'This book is awesome!', '2019-11-05 19:36:29'),
(8, 23, 18, 'Another comment with a different user', '2019-11-05 19:33:31'),
(7, 19, 18, 'This is a new comment', '2019-11-05 19:30:09'),
(10, 19, 18, '@JohnSmith90, no its awful and you suck', '2019-11-05 19:38:59'),
(11, 19, 18, 'another comment', '2019-11-05 20:01:18'),
(12, 19, 17, 'New test comment for treehouse', '2019-11-05 20:12:20'),
(13, 19, 19, 'Another comment from moby dick', '2019-11-05 20:12:49'),
(14, 19, 20, 'test', '2019-11-05 20:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

DROP TABLE IF EXISTS `discussion`;
CREATE TABLE IF NOT EXISTS `discussion` (
  `discussion_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `post` mediumtext NOT NULL,
  `comment_ID` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`discussion_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discussion`
--

INSERT INTO `discussion` (`discussion_ID`, `user_ID`, `subject`, `post`, `comment_ID`, `timestamp`) VALUES
(19, 19, 'moby dick', '\"Moby Dick\" redirects here. For other uses, see Moby Dick (disambiguation).\r\nMoby-Dick; or, The Whale\r\nMoby-Dick FE title page.jpg\r\nTitle page, first American edition of Moby-Dick\r\nAuthor	Herman Melville\r\nIllustrator	Rockwell Kent (1930 Lakeside Press ed.)\r\nCountry	United States\r\nLanguage	English\r\nGenre	Novel, adventure fiction, epic, sea story, encyclopedic novel\r\nPublisher	\r\nRichard Bentley (Britain)\r\nHarper & Brothers (US)\r\nPublication date\r\nOctober 18, 1851 (Britain)\r\nNovember 14, 1851 (US)\r\nDewey Decimal\r\n813.3\r\nLC Class	PZ3.M498 Mo3\r\nMoby-Dick; or, The Whale is an 1851 novel by American writer Herman Melville. The book is sailor Ishmael\'s narrative of the obsessive quest of Ahab, captain of the whaling ship Pequod, for revenge on Moby Dick, the giant white sperm whale that on the ship\'s previous voyage bit off Ahab\'s leg at the knee. A contribution to the literature of the American Renaissance, the work\'s genre classifications range from late Romantic to early Symbolist. Moby-Dick was published to mixed reviews, was a commercial failure, and was out of print at the time of the author\'s death in 1891. Its reputation as a \"Great American Novel\" was established only in the 20th century, after the centennial of its author\'s birth. William Faulkner said he wished he had written the book himself,[1] and D. H. Lawrence called it \"one of the strangest and most wonderful books in the world\" and \"the greatest book of the sea ever written\".[2] Its opening sentence, \"Call me Ishmael\", is among world literature\'s most famous.[3]\r\n\r\nMelville began writing Moby-Dick in February 1850, and finished 18 months later, a year longer than he had anticipated. Writing was interrupted by his meeting Nathaniel Hawthorne in August 1850, and by the creation of the \"Mosses from an Old Manse\" essay as a result of that friendship. The book is dedicated to Hawthorne, \"in token of my admiration for his genius\".\r\n\r\nThe basis for the work is Melville\'s 1841 whaling voyage aboard the Acushnet. The novel also draws on whaling literature, and on literary inspirations such as Shakespeare and the Bible. The white whale is modeled on the notoriously hard-to-catch albino whale Mocha Dick, and the book\'s ending is based on the sinking of the whaleship Essex in 1820. The detailed and realistic descriptions of whale hunting and of extracting whale oil, as well as life aboard ship among a culturally diverse crew, are mixed with exploration of class and social status, good and evil, and the existence of God. In addition to narrative prose, Melville uses styles and literary devices ranging from songs, poetry, and catalogs to Shakespearean stage directions, soliloquies, and asides.\r\n\r\nIn October 1851, the chapter \"The Town Ho\'s Story\" was published in Harper\'s New Monthly Magazine. The same month, the whole book was first published (in three volumes) as The Whale in London, and under its definitive title in a single-volume edition in New York in November. There are hundreds of differences between the two editions, most slight but some important and illuminating. The London publisher, Richard Bentley, censored or changed sensitive passages; Melville made revisions as well, including a last-minute change to the title for the New York edition. The whale, however, appears in the text of both editions as \"Moby Dick\", without the hyphen.[4] One factor that led British reviewers to scorn the book was that it seemed to be told by a narrator who perished with the ship: the British edition lacked the Epilogue, which recounts Ishmael\'s survival. About 3,200 copies were sold during the author\'s life.', NULL, '2019-11-05 20:01:02'),
(17, 19, 'Treehouse', 'This is a new forum post about treehouses. We can discuss tree houses and all the cool things they do here.', NULL, '2019-11-04 19:15:01'),
(18, 19, 'Mice and Men', 'Two migrant field workers in California on their plantation during the Great Depressionâ€”George Milton, an intelligent but uneducated man, and Lennie Small, a bulky, strong man but mentally disabledâ€”are in Soledad on their way to another part of California. They hope to one day attain the dream of settling down on their own piece of land. Lennie\'s part of the dream is merely to tend and pet rabbits on the farm, as he loves touching soft animals, although he always accidentally kills them. This dream is one of Lennie\'s favorite stories, which George constantly retells. They had fled from Weed after Lennie touched a young woman\'s dress and would not let go, leading to an accusation of rape. It soon becomes clear that the two are close and George is Lennie\'s protector, despite his antics.\r\n\r\nAfter being hired at a farm, the pair are confronted by Curleyâ€”The Boss\'s small, aggressive son with a Napoleon complex who dislikes larger men, and starts to target Lennie. Curley\'s flirtatious and provocative wife, to whom Lennie is instantly attracted, poses a problem as well. In contrast, the pair also meets Candy, an elderly ranch handyman with one hand and a loyal dog, and Slim, an intelligent and gentle jerkline-skinner whose dog has recently had a litter of puppies. Slim gives a puppy to Lennie and Candy, whose loyal, accomplished sheep dog was put down by fellow ranch-hand Carlson.\r\n\r\nIn spite of problems, their dream leaps towards reality when Candy offers to pitch in $350 with George and Lennie so that they can buy a farm at the end of the month, in return for permission to live with them. The trio are ecstatic, but their joy is overshadowed when Curley attacks Lennie, who defends himself by easily crushing Curley\'s fist while urged on by George.\r\n\r\nNevertheless, George feels more relaxed, to the extent that he even leaves Lennie behind on the ranch while he goes into town with the other ranch hands. Lennie wanders into the stable, and chats with Crooks, the bitter, yet educated stable buck, who is isolated from the other workers due to being black. Candy finds them and they discuss their plans for the farm with Crooks, who cannot resist asking them if he can hoe a garden patch on the farm albeit scorning its possibility. Curley\'s wife makes another appearance and flirts with the men, especially Lennie. However, her spiteful side is shown when she belittles them and threatens to have Crooks lynched.\r\n\r\nThe next day, Lennie accidentally kills his puppy while stroking it. Curley\'s wife enters the barn and tries to speak to Lennie, admitting that she is lonely and how her dreams of becoming a movie star are crushed, revealing her personality. After finding out about Lennie\'s habit, she offers to let him stroke her hair, but panics and begins to scream when she feels his strength. Lennie becomes frightened, and unintentionally breaks her neck thereafter and runs away. When the other ranch hands find the corpse, George realizes that their dream is at an end. George hurries to find Lennie, hoping he will be at the meeting place they designated in case he got into trouble.\r\n\r\nGeorge meets Lennie at the place, their camping spot before they came to the ranch. The two sit together and George retells the beloved story of the dream, knowing it is something they will never share. He then euthanizes Lennie by shooting him, because he sees it as an action in Lennie\'s best interest. Curley, Slim, and Carlson arrive seconds after. Only Slim realizes what happened, and consolingly leads him away. Curley and Carlson look on, unable to comprehend the subdued mood of the two men.', NULL, '2019-11-05 17:53:37'),
(20, 19, 'new post', 'test', NULL, '2019-11-05 20:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `user_confirmed` varchar(10) NOT NULL,
  `user_level` int(10) UNSIGNED NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_ID`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `username`, `email`, `password`, `user_confirmed`, `user_level`, `date_created`) VALUES
(19, 'etefft', 'erich.tefft@gmail.com', '$2y$10$KVbsc/.wn0R.QHQ5KN8aM.NITlIgEl48MOy9lhQ02mmPgxzxUV6F2', 'no', 1, '2019-10-19 20:06:37'),
(20, 'bro', 'erichtefft@gmail.com', '$2y$10$naSd2Ecmog0gx1kkHtiZhesSS2Kpeo3jeM2.29iO2irrGrKqYUTXm', 'no', 1, '2019-10-20 02:49:41'),
(21, 'tefft', 'tefft@gmail.com', '$2y$10$mU6u0vFfwFNr6/.GEYBC0OKflxiK4AN3Zx1czmttB59RV/d.mzvk6', 'no', 1, '2019-10-23 19:41:44'),
(22, 'tefft90', 'erich@gmail.com', '$2y$10$iQVkUa4h3siK76gvyNZ2aO8VAaf3GyP4OFgmp6zkV6Yxh8uGkNosO', 'no', 1, '2019-10-30 19:56:38'),
(23, 'JohnSmith90', 'test@gmail.com', '$2y$10$hS76gZ7zPQhD3sOCB25gZOYX4SAtOYSHlbqKoGc6FD6OnvuHkrl9W', 'no', 1, '2019-11-05 19:32:19'),
(24, 'testy', 'test@test.com', '$2y$10$slO5KoNc9gNlc0l9JoIxBupA0I4KiJF3Cu0rq6mtiSH0OxuuHEzli', 'no', 1, '2019-11-05 19:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `vote_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  PRIMARY KEY (`vote_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
