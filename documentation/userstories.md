# User stories and points
points estimation (0 to 10 scale)

## #5 communication - 8 pts
As a teacher assistant, I want to be able to communicate with a specific team
in private through a chat in order to give them directive and feedback on
their work.

	* Done: 

	* To do: (Mikel, David; 3 weeks) resuse chat system from other areas of project and add them into the group page

## #7 uploading files - 5 pts
As a teacher assistant, I want to be able to upload or remove course related
materials in order to provide tasks to students.

	* Done: 

	* To do: (Erdem, 3 weeks) Will add file upload button and drag and drop option, a remove option will also be implemented with HTML5 and js. 
	* To do: (Mikel, 2 weeks) Will create file upload ability using php.    


~~3)(no issue associated)
	a) As a teacher assistant, I want to be able to make appointment with each team,
	in order for me to discuss and help them on their project.
	b) As a teacher assistant, I want to be aware of a team's availability, 
	in order to avoid scheduling conflicts when making appointments.~~

## #11 online participation - 2 pts
As a teacher assistant, I want to be able to track the contribution of each team member,
 in order to evaluate every participant fairly. 

 	* Done: **_Dependency constraint_ see issue #34 **

 	* To do: (Nick, David; 6 weeks) Implement a user history feature which will track and display a sort of contribution history for each team member
 	* To do: (William; 2 weeks) Add specific authorization for the TA to view contribution data.

## #13 group communication - 8 pts
As a student, I want to be able to communicate with my team so that we can share ideas 
and build our project.

	* Done: (nick) In MySQL, created a relationship between a student and his project team that will contain the message he wishs to send and a time stamp to effectively sort messages in the chat.

	* To do: (Nick, Alex; 4 weeks) PHP function to sort all project-messages tuples. Display content dynamically with javascript.
	* To do: (Mikel, David; 3 weeks) add and modify accordingly open source chat system built with PHP and MySQL. 

## #20 student profile - 4 pts
As a student, I want to have a profile page where I can select for which project of mine 
I wish to work on. 

	* Done: **_Dependency constraint_ see issue #34 **

	* To do: (Sai-Shan, Erdem; 3 weeks) Display a logged in student's projects and access a specific project through a single click

## #6 viewing materials - 5 pts
As a student, I would like to be able to view the course materials that the teacher's assistant 
might upload into my group.
	
	* Done: **_Dependency constraint_ see issue #7 **

	* To do: (Alex, William; 4 weeks) Display the documents the TA uploaded on a specific page. Notification when a document is uploaded by the TA. 

## #12 view group page - 4 pts
As a teaching assistant, I want to be able to view a page dedicated to a certain group, 
allowing me to view relevant information and interact with the team.

	* Done: **_Dependency constraint_**

	* To do: (Erdem, William; (sai-shan); 3 weeks) Add a new page with content and styling which displays the data related to a group (Names, IDs, emails, accounts..)
	* To do: (Erdem, William, (sai-shan); 3 weeks) Add links for the TA to have access to each group page.

## #1 user account - 5 pts
As a student or teacher's assistant, I want to be able to log into the website with my personal
account.

	* Done: (Nick) Created student and TA entities in database, each having different properties
	* Done: (Mikel) Added basic structure, content and style to website with HTML and CSS

	* To do: 
		- (Nick, 1 week) Create a registration page that will automatically update/insert data in database
		- (William, 2 weeks) Make registration page look good using CSS,JS and other funky stuff :)
		- (Nick, 2 weeks) PHP condition check to give TAs more privileges

## #34 Class division - 5 pts
As a teacher assistant, I want to be able to divide my class into groups myself so that students don't lose time to make the group themselves or no student is left alone.

	* Done: (Nick) Created a project entity related to one TA and many students in MySQL
	
	* To do: (Nick, 2 weeks) Create php mixed with MySQL queueries to allow a TA to divide a class into groups and populate the project 

	* To do: (Sai-Shan, 2 weeks) Create UI element to be used to divide students into groups
	
