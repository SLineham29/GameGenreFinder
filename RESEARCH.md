When trying to use values from the env file within a page, I didn't know that I couldn't simply call them straight from
the ENV and a warning came up when trying it. Looking through the Laravel documentation, it mentioned that I need to
first call them in the services.php file in the config folder, then call them using the name defined there.

My try/catch in IGDBAuth caught a LibCurl error no. 60 when trying to call the IGDB API. The solution, found on Stack Overflow, was to download
a CURl CA certificate from their website and point my php.ini to it to properly verify my local testing server. The API worked fine once
the certificate was downloaded.
