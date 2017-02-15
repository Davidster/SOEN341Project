## User stories and points
points estimation (0 to 10 scale)

**#5 communication - 8 pts**
As a teacher assistant, I want to be able to communicate with a specific team
in private through a chat in order to give them directive and feedback on
their work.

**#7 uploading files - 5 pts**
As a teacher assistant, I want to be able to upload or remove course related
materials in order to provide tasks to students.

~~3)(no issue associated)
	a) As a teacher assistant, I want to be able to make appointment with each team,
	in order for me to discuss and help them on their project.
	b) As a teacher assistant, I want to be aware of a team's availability, 
	in order to avoid scheduling conflicts when making appointments.~~

**#11 online participation - 2 pts**
As a teacher assistant, I want to be able to track the contribution of each team member,
 in order to evaluate every participant fairly. 

**#13 group communication - 8 pts**
As a student, I want to be able to communicate with my team so that we can share ideas 
and build our project.

**#20 student profile - 4 pts**
As a student, I want to have a profile page where I can select for which project of mine 
I wish to work on. 

**#6 viewing materials - 5 pts**
As a student, I would like to be able to view the course materials that the teacher's assistant 
might upload into my group.

**#12 view group page - 4 pts**
As a teaching assistant, I want to be able to view a page dedicated to a certain group, 
allowing me to view relevant information and interact with the team.

	

**#1 user account - 5 pts**
As a student or teacher's assistant, I want to be able to log into the website with my personal
account.

	* Create student and TA entities in database, each having different properties (1 week)
		- Nick: I created student and TA tables in phpmyadmin (GUI for MySQL)
		- Nick(to do): Refine database schema and entity attributes.
	* Create a registration page that will automatically update/insert data in database (2 weeks)
		- Nick(to do): Will formulate MySQL queueries to populate db and blend with php functions.
		- Someone(to do): Make registration page look good using CSS,JS and other funky stuff :)
	* Create different privileges for TA users. (2 weeks)
		- Nick(to do): Use php SESSIONS to cache user information and enable different functionnalities according to the user logged in.
		- Somewhat dependant on features to be implemented.

**#34 Class division - 5 pts**
As a teacher assistant, I want to be able to divide my class into groups myself so that students don't lose time to make the group themselves or no student is left alone.

	* Create project relationship between TA and student entities (1 week)
		- Nick: I created the project relationship in phpmyadmin
	* Make TA class division function
		- Nick(to do): Create php mixed with MySQL queueries to allow a TA to divide a class into groups (3 weeks) 
	
