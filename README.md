# Test Repository

## Application Overviews
The application is utilising PHP cURL to retrieve the JSON data from the target endpoint.
This application is coded with PHP and HTML in order to keep the system as simple as possible.

The PHP classes are separated into 2, the cURL handler (API_Handler.php) and the actual data processing classes (Data_Process.php).


## How to Run
Please run this repository with PHP 7.3 or above due to the PHPUnit and Namespace structure.

The application index.php will run automatically once the directory is executed using PHP.
E.g. with localhost as the root and directory "/test-repo/", please run "http://localhost/test-repo/" to run the codes.


## Known Issues
- Utilising PHP 7.2 with this repository will probably cause an error, due to Namespace bug on the PHP version.
- Utilising PHP 5.5 and below might cause the system to encounter errors due to PHP codes versioning.