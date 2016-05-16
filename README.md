# PHP groupwork project
**Deadline** examination day - please attend the same day with all group members

## Information
1. Application:
    * Debattle : Everything is Challengeable!
    * Islam Muhammad
    * Debattle is an app that allows users to challenge each other of their position on certain topics (Pro and Against);
    * The app provides an easy way for users to challenge and respond to each others on certain motions. It doesn't have an age preference as it can be used by any person;
    * functionalities of the app
        * It is possible to create user
        * User send a Debattle Request to other users
        * Users can view sent and received Debattle Requests
        * Users can have access to a list of the current Users on the Website
        * Users can send a Debattle Request to any website user
        * Users can edit their sent Debattle Request, or delete them
        * Users can respond to their received Debattle Request or delete them

    * **summary:** In the process of developing such app and based on past debate experience, and observing how online heated debates evolve, it is clear that these discussions/debates are less structured and need to be more organised. From this course, and while working on the idea of this app, I've learnt how to deal with DB, and present the data on a website. All the work that has been done was related to PHP and MySQL. I believe in order to reach a better functionality of the website, and add more options (Threads, Time-Control, Rich Media, Sharing, Embedding, Voice...etc functionalities), one needs to get more knowledge of jQuery, CSS, much more indepth web programming....etc. The Talkshow app is what Debattle aspires to be like.


2. **Web application/service requirements:**
    * The app depends on two DB tables; Users and Debattle Requests. The Requests carry all the information regarding the Debattles. (you can export them from phpMyAdmin)
    * Only two tables used; 
    * Debattle_Request: `id`, `username`, `challengee`, `motion`, `position`, `visibility`, `start_date`, `end_date`, `favcolor`, `characters`, `created`, `reply`, `deleted`SELECT * FROM `debattle_request` 
    * Debattle_Users: `id`, `username`, `password`, `first_name`, `last_name`, `created`SELECT * FROM `debattle_users`
    * code is separated by files (you have config file, functions file etc.)
    * application has enough functionalities (you have solved all the issues)
    * it is possible to see what wach team member has developed 
