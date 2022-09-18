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