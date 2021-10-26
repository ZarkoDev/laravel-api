Standard commands (composer, npm etc) for running the project + commands for tests and async job tasks
- migrations and seeds
- php artisan queue:listen
- php artisan queue:work --queue=tasks,default


Specifications:
- For the given task is not permitted using of libraries such as Sanctum, Passport, JWT-Auth, SDK related to the Clearbit API.
- The first part of the task is to make sure that the API that you built up is secured and every API request is being signed with some sort of AuthToken.

Requirements Phase 1:
- In order to allow to the admin to create a system user, there are needed some sturcts which populates on demand the database with at least one dummy user.
- Exposed endpoint for login POST /v1/api/login
- Exposed endpoint for register POST /v1/api/sign-in
- Exposed endpoint for forgotten password POST /v1/api/forgotten
- Recieved email with some magic link or hasg which needs to be added to the forgotten password endpoint when user change the password. As EMAILER you could use the logger driver oflaravel where the email it will be sent to the mail log file.
- Exposed endoint for change the password POST /v1/api/change-passowrd
- UnitTests and API tests which ensures the quality of the provided work
- Using of exceptions where it is needed
- Using of Resources, Custom Request classes
- Secure endpoints by CSRF tokens where this is needed

Requirements Phase 2:
- Allow user to create a request for delivering infromation through ClearBit API
- Allow to user to receive on demand by API endpoint all the pieces of scraped information using the domain website of the company
- Make sure that the requests for download of comapny details will be not waiting all the data to be downlaoded and will be used some workaround to provide this asyncronomus approach.
- Allow to user to check every created task/request and status for that is being downloaded by the background worker.
- Use right HTTP status codes in the API Responses
- Make sure all the resources returned by the API are reusable
- Make sure it is returned an error when something went wrong and this error do not expose sensetive server data which allow to hackers to corrupt the server
- Make sure that all the validations while the user do a request are implemented
- Make sure that the code has at least 80% code coverage.
