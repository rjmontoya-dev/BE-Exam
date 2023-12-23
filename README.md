### Project Description
This project is an implementation of the AdminLTE v3 admin template, featuring a sidebar and container layout similar to the provided template.

### Features:
Authentication: Utilizes Laravel Jetstream for authentication with the added functionality of "Remember Me."

Technologies: Built with Inertia.js to enhance the user experience and streamline front-end development.

CRUD Operations: Implements CRUD functions, complete with pagination and a search box for efficient data management.

### Known Issues:
Video Player Bug: There is an ongoing issue with the video player. Clicking on a different video triggers an error: "The element supplied is not included in the DOM." The bug is currently being addressed, and any suggestions or insights are welcomed.

Responsive Design: The admin panel design is currently not fully responsive to various screen sizes. Expect potential design issues on large or small screens. Efforts are ongoing to enhance responsiveness.

Feel free to explore the project, and any contributions or feedback are highly appreciated!


### Installation
You'll need to install Node.js >=v18.12+ (Recommended Version) (NPM comes along with it)

Installed composer and php version of 8.1 above

Use terminal and navigate to the project root.

- Clone the repository with the following command:

```bash
git clone https://github.com/rjmontoya-dev/BE-Exam.git

copy .env.example and rename to .env
configure the database name, username and password of the project inside the .env file
of your desire.

```
- Then run : <code> composer install </code>
- Then run : <code> npm install </code>
- To generate an APP_KEY run : <code> php artisan key:generate </code>
- To populate the db run : <code> php artisan migrate:fresh --seed </code>

To start the project : 
- run : <code>php artisan serve </code>
- Open new terminal or tab run : <code>npm run dev </code>

The Default credentials is:
username : admin@admin.com
password : password



 

