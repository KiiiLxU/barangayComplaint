# TODO: Update User Roles

- [x] Update migration to set default role to 'resident'
- [x] Update DatabaseSeeder: Change admin to 'kagawad', add 'kapitan' user, change regular user to 'resident'
- [x] Update AuthContext to recognize 'kagawad' and 'kapitan' as admin roles
- [x] Run database seeder to apply changes
- [x] Add first_name, last_name, contact_number to users table
- [x] Update registration form and controller for new fields
- [x] Restrict contact_number to numbers only
- [x] Update registration test
- [x] Run all tests successfully
- [x] Add password length limitation: min 6, max 15 characters
- [x] Add password max length limitation to login form
- [x] Add contact number limitation to exactly 11 digits
- [x] Update ComplaintController to allow 'kagawad' and 'kapitan' roles for admin actions
