# Build Modern Laravel Apps Using Inertia.js

Laracasts series: https://laracasts.com/series/build-modern-laravel-apps-using-inertia-js
## Section 1 The Basics
### Episode 2 Install and Configure Inertia
We're now ready to install and configure Inertia. In this episode, we'll closely following the Inertia docs, as we pull in the server-side and client-side adapters for Laravel and Vue, respectively. We'll next create the initial layout file, and then compile our assets down using Laravel Mix.

Things You'll Learn
- Install Inertia
- Create an Inertia App
- The @inertia Directive

Instalation guide server-side: https://inertiajs.com/server-side-setup
1. Install Intertia: composer require inertiajs/inertia-laravel
2. Paste to app.blade.php (rename ewlcome.blade.php) 
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
    </html>
3. php artisan inertia:middleware
4. Register middleware in App\Http\Kernel.
    'web' => [
        // ...
        \App\Http\Middleware\HandleInertiaRequests::class,
    ],
Instalation guide client-side: https://inertiajs.com/client-side-setup
1. npm install @inertiajs/inertia @inertiajs/inertia-vue3
2. npm install vue@next
3. npm install -D @vue/compiler-sfc
4. Paste to resources\js\app.js
    import { createApp, h } from 'vue'
    import { createInertiaApp } from '@inertiajs/inertia-vue3'

    createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
        .use(plugin)
        .mount(el)
    },
    })
5. Create Pages directory into resources\js
6. webpack.mix.js add vue support
7. npm install
8. npx mix x2 (if not working run first: npm update vue-loader. If it is not installed, install it: npm i vue-loader)
--
mix-manifest.json - location js and css
### Episode 3 Pages
Now that we've installed and configured Inertia, we can now create our first Page component. You can think of these as the client-side equivalent of a typical Blade view. Let's have a look.

Things You'll Learn
- Page Components
- Inertia::render()

1. routes\web.php replace view function to inertia
2. npm run watch or npx mix watch or npx mix and php artisan optimize
### Episode 4 Inertia Links
Let's now create a few pages that we can seamlessly link between. But as you'll quickly see, we can't use a standard anchor tag to link from one page to the next. That would perform a full page refresh, which we of course don't want. Instead, we should pull in Inertia's Link component, which will intercept the click and automatically perform an AJAX request to the server to fetch the appropriate JSON response for the new page.

Things You'll Learn
- Inertia Links
- AJAX Requests

1. import { Link } from '@inertiajs/inertia-vue3';
2. Example use: <Link href="/users">Users</Link>
### Episode 5 Progress Indicators
If, for any reason, a server request takes a bit of time to prepare the appropriate response data, the user will currently be left waiting without an ounce of feedback. To remedy this, we can install Inertia's progress indicator package, which will display a familiar loading bar at the top of the page for any long-running request.

Things You'll Learn
- Progress Indicators
- PHP sleep()

1. npm install @inertiajs/progress
2. Import to app.js:
    import { InertiaProgress } from '@inertiajs/progress'

    InertiaProgress.init()
### Episode 6 Perform Non-GET Requests
We can also use Inertia's Link component to perform non-GET requests. For example, what if we want to render a button that submits a POST request to log the user out. How might we do that, when using the Link component?

Things You'll Learn
- Link Component
- Set the Method
- Render as a Button

1. Example for post method into web.php: <Link :data="{ foo: 'bar' }" href="/logout" method="post" as="button">Log out</Link> as="button" must be, becouse new tab not support post method. Parametr :data="{ foo: 'bar' }" sending post data.
### Episode 7 Preserve the Scroll Position
You'll often want to make an Inertia request to the current page in order to retrieve updated data. However, by default, any clicked link will of course reset the scrollbar's position to the top of the page. In situations when that's not desirable, we can leverage the preserve-scroll attribute on the Link component.

Things You'll Learn
- Preserve Scroll Position

1. Attribude preserve-scroll to scroll position after refresh<Link href="/users" class="text-blue-500" preserve-scroll>Refresh</Link>
### Episode 8 Active Links
Next up, we should receive active links. At the moment, if you click any of the items in the navigation bar, there isn't any visual indication that you did in fact select that link. Let's fix that by leveraging both the $page.url and $page.component properties that Inertia provides to us.

Things You'll Learn
- Set Active Links
- Extract NavLink Components

1. :class="{'font-bold underline': $page.url === '/'}" $page.url == debug->vue->Inertia->props->url.
2. $page.url.startsWith === '/users' or $page.component === 'Users'
### 9 Layout Files
We can finally move on to layout files. At the moment, every page must manually import and render the navigation section. But, clearly, this isn't ideal. Instead, let's extract a Layout file that can be responsible for all portions of the UI that should remain consistent as we browse from page to page.

Things You'll Learn
- Extract Layouts
- Basic Section Padding
### Section 10 Shared Data
Now that we've successfully extracted a Layout component, the next thing we need to sort out is how to share data across components. Luckily, Inertia provides a nice and friendly solution that we'll review in this episode.

Things You'll Learn
- HandleInertiaRequests Middleware
- Share Data

Define user into HandleInertiaRequests Middleware
### Episode 11 Global Component Registration
Before we move on to persistent layouts in the next episode, first I'd like to quickly discuss global component registration. For example, it's slightly combersome to import Inertia's Link component every time you want to render what is effectively an anchor tag. If you wish, we can solve this by registering it as a global component.

Things You'll Learn
- Register Vue Components Globally
- Script Setup

    <script setup> - delete export default {} or registry global component into app.js
### Episode 12 Persistent Layouts
Currently, layout state is reset each time we click from page to page. This is because every page component includes the Layout as part of its template. As such, when you visit a new page, that component, including the layout, is destroyed. If you instead want state from your layouts to persist across pages - such as for a podcast that continues playing as your browse the site - we'll need to review persistent layouts.

Things You'll Learn
- Persistent Layouts
- State

Rebulid Layout - podscast without reset
### Episode 13 Default Layouts
Now that we have persistent layouts working, if you wish, we can next remove the need to manually import and set the Layout for every single page component.

Things You'll Learn
- Default Layouts
- CommonJS Imports

Default page layout (into app.js) and remove scripts into pages: 
    import Layout from "./Shared/Layout";

    resolve: name => {
        let page = require(`./Pages/${name}`).default;

        page.layout ??= Layout;

        return page;
    },
### Episode 14 Code Splitting and Dynamic Imports
Before we move on to something else, let's quickly touch upon dynamic imports and how that can potentially affect your bundle. If the app you're building warrants it, we can asynchronously download the JavaScript for each page in real-time, as the user browses your site.

Things You'll Learn
- Async Functions
- Dynamic Imports
- Mix Extraction

Add .extract() into webpack.mix.js - dynamic create js file to antoher sites.
!!If not extract() function then load one js file!!
npx mix adding manifest.js file and vendor.js file. Must addingo to app.blade.php

Update app.js
    resolve: async name => {
    
    let page = (await import(`./Pages/${name}`)).default;

    // ??= == OR
    page.layout ??= Layout;

    return page;
  },

Run npx mix

Loading site js file (debug)
### Episode 15
Next up, let's figure out how to make the head portion of our HTML dynamic. Luckily, Inertia makes this a cinch by offering a Head component that we can pull in.

Things You'll Learn
- Inertia's Head Component
- Set Head Defaults

Inertia Head component: import { Head } from '@inertiajs/inertia-vue3';
head-key="description" - only one element about this key on site
### Episode 16 An Important SPA Security Concern
In this episode, as we begin our review of how Eloquent data can be fetched and sent to the client-side, we'll need to take some time to discuss an incredibly important concern when building any SPA: data that is returned from an AJAX request is of course entirely visible to the end-user. With this in mind, you must pay special attention to ensure that you aren't accidentally exposing private information.

Things You'll Learn
- Eloquent Data Fetching
- Collection Mapping
- SPA Security

Add database.sqlite
### Episode 17 Pagination
You'll be happy to hear that Laravel makes a pagination laughably simple to implement. In this episode, we'll add a list of pagination links to the bottom of our users table.

Things You'll Learn
- Laravel Pagination
- The through() Method
- Dynamic Vue Components

### Episode 17 Pagination
Now that we have pagination working properly, let's next implement real-time search filtering. When we type into a search box, the table of users should automatically refresh to show only the users that match the given search query. Let's get to work!

Things You'll Learn
- Filtering
- State Preservation
- Eloquent Search
## Section 2 Forms
### Episode 19 Inertia Forms 101
Processing forms With Vue, Inertia, and Laravel is a joy. It instantly feels familiar, while offering wild amounts of power and flexibility. Let's by asynchronously submitting a simple form for creating a user.

Things You'll Learn
- Inertia Post Requests
- Laravel Validation

Changes:
- Add resources/js/Pages/Users/Create.vue
- resources/js/Pages/Users.vue → resources/js/Pages/Users/Index.vue
- modify web.php
### Episode 20 Display Failed Validation Messages
In the previous episode, we got the "happy path" of our form to work properly. But what about situations where the validation checks failed? Let's conditionally render a red validation message below each input that failed the validator.

Things You'll Learn
- Inertia Errors
- Display Validation Messages

Changes:
- modify resources/js/Pages/Users/Create.vue
- modify resources/js/Pages/Users/Index.vue
### Episode 21
Anyone who has ever shipped a form to production knows that users will do all sorts of weird things that you didn't expect. To demonstrate this, we'll solve the "spam click the submit button" problem by conditionally disabling the button after the first click. Then, we'll switch over to using Inertia's form helper, which makes tasks like this laughably simple.

Things You'll Learn
- Inertia's Form Helper

Changes:
- modify resources/js/Pages/Users/Create.vue. Add Inertia's Form Helper. Password return server-side error (not required attribute)
## Section 3 Throttling
### Episode 22 Better Performance With Throttle and Debounce
Whenever you make a network request as a response to the user typing into an input, it's essential that you implement some form of request throttling. There's no need to make dozens of instant requests to your server if you don't have to. In this episode, we'll solve this by reviewing Lodash's debounce and throttle functions and discussing the differences between the two.

Things You'll Learn
- Throttle
- Debounce
- Network Requests

Command:
- npm install loadash --save-dev
- In file: import debounce from "lodash/debounce";

Fix search request after all words debounce function - trigger after finish write into input
    watch(search, debounce(function (value) {
        Inertia.get('/users', { search: value }, { preserveState: true, replace: true });
    }, 300));
## Section 4 Authentication and Authorization
### Episode 23 Authentication With Inertia
Authentication with Inertia is, really, no different than performing authentication in a traditional server-side Laravel app. No tokens. No OAuth. None of that. Instead, submit the form with Inertia in the way you've already learned, and then let Laravel handle the rest. This will all feel incredibly familiar to you.

Things You'll Learn
- Basic Authentication
- Intended Redirects

Changes:
- add app/Http/Controllers/Auth/LoginController.php
- modify app/Http/Middleware/HandleInertiaRequests.php
- add resources/js/Pages/Auth/Login.vue
- modify resources/js/Shared/Nav.vue
- modify resources/js/app.js
- modify routes/web.php
- modify resources/js/app.js 
- \App\Http\Middleware\HandleInertiaRequests::class, move to web group middleware in kernel.php
