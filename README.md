<<<<<<< HEAD
### Getting started

1. Create database `train-booking`
2. Move to the project folder and launch a terminal instance from the root.
3. On the terminal run, `composer install`
4. Create a `.env` file by using the provided run, `mv .env.example .env`, this will rename the provided `.env.example` file to `.env`.
5. Edit the `.env` file adding your database connections details.
6. Create an MPESA app on https://developer.safaricom.co.ke/
7. Filling in the MPESA config details on the .env
8. Generate api key using the command, `php artisan key:generate`
9. Run `php artisan migrate`
10. (Optional) Fill the database with dummy data, run `php artisan db:seed`.
11. Start server,run: `php artisan serve`.
12. Serve the website on a secure server on ngrok or localtunnel. (Required for mpesa functionality)
=======
# Elite-Train-Booking
A train booking web platform for Kenya Railway. The System makes use of two core routes, the commuter rail route and the intercounty. Train , routes and schedules can be added in the respective routes. It makes use of the Mpesa API (Daraja API) to facilitate transactions.
>>>>>>> d9bbae73200171be5c705d07be616c92d24e97e9
