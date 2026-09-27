For this challenge, I've decided to try both a language and framework that I have never used before, PHP and Laravel
with a Livewire frontend. Because of this, almost everything that I had to learn here was completely new to me.

The first thing I do when learning a new language is look through the documentation for the basics and looking for
a guide on how to set up a blank project. When starting up the app, I had the choice of using different "starter kits"
that adds pre-made features like user accounts, a login page, and user authentication. After using the documentation to
see everything that's included in the kit, I found that none of it is needed for my project, so I opted not to use one
this time, but I now know it would be better to use one in a future project with a much larger scope.

Alongside the starter kit choice, I also had multiple frontends to choose from, including ones I'm already familiar with
like React. I researched each of the unfamiliar frontends and found they each use TypeScript/JavaScript as their language,
except for Livewire, which uses PHP just like the backend. Because of this difference, I decided to go Livewire because
I thought it would be much easier for me to learn if the language for the entire stack (not counting HTML) was the same.

Using Livewire also came with even more things to learn because of its UI and CSS frameworks, Flux and Tailwind.
Flux was fine to learn as it's very similar to standard HTML, with only some minor syntax differences, which meant that,
again, using only the documentation was fine to learn which components replaced which HTML elements.
Tailwind, on the other hand, is very different from standard CSS, and I had to constantly keep a browser window
open beside the IDE to see which CSS style corresponds to the Tailwind shorthand style.

My original plan for this app was to also add a field for the user to specify how many hours they want the game to take.
This wasn't possible because it's a separate API call, so I tried to adapt to this by letting the user add up to 3
different genres instead of my originally planned 2 to try and let them further refine their search.

When implementing the genre and platform API calls, I could choose whether I wanted to store the responses to both in
the local SQLite database or in Laravel built-in cache feature. Both have their advantages, but I ended up deciding to
use the cache feature because you can set elements to expire after a given time frame, which means that the website can
be constantly refreshed with any new data that can be added to the API without any manual changes.

When trying to use values from the env file within a page, I didn't know that I couldn't simply call them straight from
the ENV and a warning came up when trying it. Looking through the Laravel documentation, it mentioned that I need to
first call them in the services.php file in the config folder, then call them using the name defined there.

My try/catch in my tester IGDBAuth page caught a LibCurl error no. 60 when trying to call the IGDB API. The solution,
found on Stack Overflow, was to download a CURl CA certificate from their website and point my php.ini to it to properly
verify my local testing server. The API worked fine once the certificate was downloaded. During this search, however,
someone in the forum had mentioned instead downloading a pre-configured PHP version to avoid any future issues like this occurring.
This is what led me to Laravel Herd, which downloads a pre-configured version of PHP with all the necessary extensions enabled.
Once I started using this, no further PHP-related errors occurred during development.
