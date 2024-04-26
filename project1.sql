-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2024 at 07:15 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project1`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int NOT NULL,
  `course_name` varchar(25) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`) VALUES
(1, 'msccs'),
(2, 'aiml'),
(3, 'mca');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int NOT NULL,
  `exam_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `exam_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`exam_id`, `exam_name`, `user_id`, `course_id`, `subject_id`, `topic_id`, `exam_date`) VALUES
(1, 'Exam for User 11', 11, 1, 1, 1, '2024-04-23 02:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `exam_question`
--

CREATE TABLE `exam_question` (
  `exam_question_id` int NOT NULL,
  `exam_id` int DEFAULT NULL,
  `mcq_id` int DEFAULT NULL,
  `user_answer` varchar(255) DEFAULT NULL,
  `user_answer_marks` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `result_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `topic_id` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `exam_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mcq`
--

CREATE TABLE `mcq` (
  `mcq_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `question` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `option1` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `option2` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `option3` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `option4` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `correct_answer` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `question_category` enum('memorybased','understanding','fillups','example') COLLATE utf8mb4_general_ci NOT NULL,
  `difficulty_level` enum('easy','medium','hard') COLLATE utf8mb4_general_ci NOT NULL,
  `subject_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mcq`
--

INSERT INTO `mcq` (`mcq_id`, `topic_id`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_answer`, `question_category`, `difficulty_level`, `subject_id`) VALUES
(499, 4, 'What is a linked list?', ' A linear data structure', 'A sorting algorithm', 'A type of tree structure', 'A database query language', ' A linear data structure', 'memorybased', 'easy', NULL),
(500, 4, 'Which of the following is true about a singly linked list?', 'Each node has two pointers', 'Traversal can only be done in one direction', ' It requires less memory than a doubly linked list', 'Deletion at the middle requires O(1) time complexity', 'Traversal can only be done in one direction', 'memorybased', 'easy', NULL),
(501, 4, 'What is the time complexity of inserting a node at the beginning of a linked list', 'O(1)', 'O(log n)', 'O(n)', 'O(n log n)', 'O(1)', 'memorybased', 'medium', NULL),
(502, 4, 'Which of the following is not an advantage of a linked list over an array?', 'Dynamic size', 'Ease of insertion/deletion at any position', 'Random access of elements', 'Efficient memory utilization', 'Random access of elements', 'memorybased', 'medium', NULL),
(503, 4, 'What is the purpose of a tail pointer in a linked list? ', ' It points to the previous node ', 'It points to the next node ', 'It points to the last node ', 'It points to the first node ', 'It points to the last node ', 'memorybased', 'easy', NULL),
(504, 4, 'In a circular linked list, how does the last node point to the first node?', 'NULL pointer', 'It points to the previous node ', 'it points to a special marker indicating the end', 'it directly points to first node', 'it directly points to first node', 'understanding', 'medium', NULL),
(505, 4, 'Which type of linked list allows traversal in both directions?', 'singly linked list', 'doubly linked list', 'circular linked list ', 'skip list', 'doubly linked list', 'memorybased', 'easy', NULL),
(506, 4, 'What is a dummy node in a linked list?', 'A node with null pointers', 'A node with data equal to zero', 'A node used as a placeholder', 'A node that is disconnected from the list', 'A node used as a placeholder', 'memorybased', 'medium', NULL),
(507, 4, 'How is memory allocated for nodes in a linked list?', 'Contiguous allocation', 'Stack allocation', 'Heap allocation', 'Global allocation', 'Heap allocation', 'memorybased', 'easy', NULL),
(508, 4, 'Which operation in a linked list has the highest time complexity?', 'Insertion at the beginning', 'Insertion at the end', 'Deletion at the beginning', 'Deletion at the end', 'Deletion at the end', 'understanding', 'hard', NULL),
(509, 4, 'What is the memory overhead for each node in a singly linked list in a 32-bit system?', '4 bytes', '8 bytes', '12 bytes', '16 bytes', '4 bytes', 'memorybased', 'hard', NULL),
(510, 4, 'How does memory allocation for nodes in a linked list differ from arrays?', 'Nodes are allocated contiguously in memory', 'Nodes are allocated on the stack', 'Nodes are allocated dynamically on the heap', 'Nodes are allocated statically', 'Nodes are allocated dynamically on the heap', 'memorybased', 'medium', NULL),
(511, 4, 'What is the significance of the \"next\" pointer in a linked list node?', 'It stores the value of the node', 'It points to the previous node', 'It points to the next node in the sequence', 'It contains metadata about the node', 'It points to the next node in the sequence', 'memorybased', 'easy', NULL),
(512, 4, 'In a doubly linked list, how much additional memory is required per node compared to a singly linked list?', 'Same amount', 'Half amount', 'Twice the amount', 'Three times the amount', 'Twice the amount', 'memorybased', 'medium', NULL),
(513, 4, 'When a node is dynamically allocated for a linked list, what type of memory allocation function is commonly used?', 'malloc()', 'free()', 'realloc()', 'calloc()', 'malloc()', 'memorybased', 'easy', NULL),
(514, 4, 'What is the term for memory leaks that can occur in linked lists?', 'Segmentation fault', 'Memory fragmentation', 'Memory leak', 'Dangling pointer', 'Memory leak', 'memorybased', 'hard', NULL),
(515, 4, 'How does the memory usage of a linked list compare to that of an array when it comes to dynamic resizing?', 'Linked list consumes more memory', 'Array consumes more memory', 'Both consume the same amount of memory', 'It depends on the implementation', '. Linked list consumes more memory', 'understanding', 'medium', NULL),
(516, 4, 'What happens if memory allocation fails during node creation in a linked list?', 'Program crashes', ' Operating system reallocates memory', 'Null pointer is returned', 'Garbage collector intervenes', 'Null pointer is returned', 'understanding', 'easy', NULL),
(517, 4, 'How does memory fragmentation impact the performance of a linked list?', 'It improves performance', 'It degrades performance', 'It has no impact', 'It depends on the size of the list', 'It degrades performance', 'memorybased', 'hard', NULL),
(518, 4, 'What is the role of the memory management system in a linked list?', 'To allocate memory for nodes', 'To deallocate memory for nodes', 'To manage memory leaks', 'All of the above', 'All of the above', 'memorybased', 'medium', NULL),
(519, 4, 'In a singly linked list, how many pointers does each node typically contain?', 'one', 'two', 'three', 'four', 'one', 'memorybased', 'easy', NULL),
(520, 4, 'When a node is deleted from a linked list, what happens to its memory?', 'It is immediately deallocated', 'It becomes inaccessible but remains in memory until garbage collected', 'It remains intact but with no references', 'It is marked for deletion by the operating system', 'It becomes inaccessible but remains in memory until garbage collected', 'understanding', 'medium', NULL),
(521, 4, 'What is the impact of memory fragmentation on linked list operations?', 'It has no impact', 'It may slow down traversal and manipulation operations', 'It improves memory allocation efficiency', 'It reduces memory consumption', 'It may slow down traversal and manipulation operations', 'memorybased', 'hard', NULL),
(522, 4, 'In a circular linked list, how is the end of the list identified?', 'By a null pointer', 'By a special marker indicating the end', 'By the last node pointing to the first node', 'By the last node pointing to null', 'By the last node pointing to the first node', 'memorybased', 'easy', NULL),
(523, 4, 'What is the significance of the \"data\" field in a linked list node?', 'It points to the previous node', 'It contains the value of the node', 'It points to the next node', 'It serves as metadata for memory management', 'It contains the value of the node', 'memorybased', 'easy', NULL),
(524, 4, 'When a new node is inserted into a linked list, how is memory allocated for it?', 'Memory is allocated statically', 'Memory is allocated on the heap using malloc or similar functions', 'Memory is allocated on the stack', 'Memory is allocated on the globally', 'Memory is allocated on the heap using malloc or similar functions', 'memorybased', 'medium', NULL),
(525, 4, 'What is the purpose of a \"dummy\" node in some linked list implementations?', 'To store special metadata', 'To serve as a placeholder for insertion operations', 'To mark the end of the list', 'To improve memory management efficiency', 'To serve as a placeholder for insertion operations', 'memorybased', 'hard', NULL),
(526, 4, 'How does memory management in a linked list differ from that in an array?', 'Linked lists require manual memory management', 'Arrays require manual memory management', 'Both use automatic memory management', 'Neither requires memory management', 'Linked lists require manual memory management', 'memorybased', 'easy', NULL),
(527, 4, 'the number of comparisons needed to search a singly linked list of length n for a given element is_____', 'log(2*n)', 'n/2', 'log(2*n)-1', 'n', 'n', 'fillups', 'medium', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `result_id` int NOT NULL,
  `user_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `total_marks` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`result_id`, `user_id`, `exam_id`, `total_marks`) VALUES
(51, 11, 1, 2),
(52, 11, 1, 3),
(53, 11, 1, 5),
(54, 11, 1, 5),
(55, 11, 1, 5),
(56, 11, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int NOT NULL,
  `subject_name` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `course_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `course_id`) VALUES
(1, 'oocp', 1),
(2, 'dbms', 1);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `topic_id` int NOT NULL,
  `topic_name` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `subject_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`topic_id`, `topic_name`, `subject_id`) VALUES
(1, 'array', 1),
(2, 'inheritance', 1),
(4, 'linked list', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `mobileno` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `user_category` enum('admin','student','faculty') COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `password` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `passkey` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `passkeyval` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('approved','pending') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `course_id`, `name`, `mobileno`, `email`, `user_category`, `username`, `password`, `passkey`, `passkeyval`, `status`) VALUES
(2, 1, 'Parin', '0888888877', 'parin@gmail.com', 'student', 'parin_210', '$2y$10$sb3nzlIjF0GGuNx2FiO5G.hIMy/M1ifd6k3zJucG1cJGeqbPqGghC', 'favteacher', 'maitry', 'approved'),
(3, 2, 'Parin', '0888888877', 'parin@gmail.com', 'student', 'parin_310', '$2y$10$3YIkr/uqboMaT/tt3wUvX.BBHKqnK9sD5Ev9rOhUXZw2zT/LBVHwC', 'favteacher', 'maitry', 'approved'),
(4, 3, 'Parin', '0888888877', 'parin@gmail.com', 'student', 'parin_410', '$2y$10$u9uWHPzEUOcX2zw.KnwJNuroaXC6pDRlcH3OVQCaYSnoiSlMpL9QW', 'favmovie', 'maitry', 'approved'),
(6, 1, 'Parin', '0888888877', 'parin@gmail.com', 'student', 'parin_610', '$2y$10$CKiAfSoQFaCp3FUXmBgBcOAX7pxA1yshSWMZdY29E3fLzxxIqNnva', 'favmovie', 'maitry', 'approved'),
(7, 2, 'Parin', '0888888877', 'parin@gmail.com', 'student', 'parin_710', '$2y$10$Hy4nUqRVLxtesBvJgDBDne4eqzrgrQ6FJy.XjEbODORmpKDWrvb6W', 'favmovie', 'maitry', 'approved'),
(9, 2, 'Parin Dhavalbhai Makwana', '0888888877', 'parin@gmail.com', 'faculty', 'parin_910', '$2y$10$Rij/4ryQEB95lu/6Eqp1Cu8HZT74WDSZOJ1.CglyhqDmBnMdUkAM6', 'favmovie', 'anaconda', 'approved'),
(10, 1, 'Lamin Janka', '3749506748', 'odogwucapalot9@gmail.com', 'faculty', 'lamin_16', '$2y$10$3GxpGvK.ghBZIAyLsP99PuJadQ6YTbL1yY9lK.jHcJEqJtyS9P/hy', 'favbook', 'Subtle', 'approved'),
(11, 1, 'Lamin Janka', '8473839316', 'odogwucapalot9@gmail.com', 'student', 'heislamin', '$2y$10$7Iv1akQcI3kICW.LLDoteeQoDNTVDWokOURd23XF.wP0MKVZnZ58.', 'favbook', 'Subtle', 'approved'),
(12, 1, 'capalot odogwu', '7846352990', 'odogwucapalot9@gmail.com', 'student', 'Lanzy', '$2y$10$NSY9C.S57TJ4g2ju1DOmdu3kjIs9aTQ3kmJyLTmzkYlwB8dJxb/BC', 'favbook', 'Subtle', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `exam_user_id` (`user_id`),
  ADD KEY `exam_course_id` (`course_id`),
  ADD KEY `exam_subject_id` (`subject_id`),
  ADD KEY `exam_topic_id` (`topic_id`);

--
-- Indexes for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD PRIMARY KEY (`exam_question_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `mcq_id` (`mcq_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `mcq`
--
ALTER TABLE `mcq`
  ADD PRIMARY KEY (`mcq_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `result_user_id` (`user_id`),
  ADD KEY `result_exam_id` (`exam_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `subject_course_id` (`course_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_question`
--
ALTER TABLE `exam_question`
  MODIFY `exam_question_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `result_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mcq`
--
ALTER TABLE `mcq`
  MODIFY `mcq_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=528;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `topic_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_topic_id` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD CONSTRAINT `exam_question_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`),
  ADD CONSTRAINT `exam_question_ibfk_2` FOREIGN KEY (`mcq_id`) REFERENCES `mcq` (`mcq_id`);

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`);

--
-- Constraints for table `mcq`
--
ALTER TABLE `mcq`
  ADD CONSTRAINT `topic_id` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
