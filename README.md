# Back-end Developer Test - [iPhone Photography School]

## About

This test is to be worked on with Laravel framework.
We need to write the code that listens for user events and unlocks the relevant achievement and badges.

**For example:**

-   When a user writes a comment for the first time they unlock the “First Comment Written” achievement.
-   When a user has already unlocked the “First Lesson Watched” achievement by watching a single video and then watches another four videos they unlock the “5 Lessons Watched” achievement.

## How to run this project?

1. Clone this replo `git clone https://github.com/yvesniyo/developer-test backend-test`
2. From the root directory run `composer install`
3. You must have a MySql database running locally
4. Update the database details in `.env` to match your local setup
5. Run `php artisan migrate --seed` to setup the database tables and seed essentials such as Achievements and Badges which will be used.

## How to run the test?

From the root directory run `php artisan test`
