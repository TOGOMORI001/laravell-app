# Session 03 - Quick Quiz Study Guide

Use this guide to review the 15 quiz questions later. The answers below follow the codelab's answer key; the explanations are written in English.

## 1. Route parameters

**Question:** In `Route::get('/posts/{slug}', [PostController::class, 'show'])`, what does `show()` receive for `/posts/bonjour`?

**Correct answer:** **b.** The string `"bonjour"` in the `$slug` parameter.

**Explanation:** Laravel matches the part of the URL that replaces `{slug}` and passes it to the controller action.

## 2. URI and route name

**Question:** What is the difference between a route's URI and its name?

**Correct answer:** **a.** The URI is what the visitor types; the name is the identifier the code passes to `route()`.

**Explanation:** A route's URI is its web address, such as `/a-propos`. Its name, such as `about`, lets views and controllers generate that address without hard-coding it.

## 3. The layout slot

**Question:** In a layout, what does `{{ $slot }}` contain?

**Correct answer:** **c.** The content placed between the view's `<x-layout>` tags.

**Explanation:** An anonymous Blade component receives the component's main body through `$slot`; the layout renders that content where `$slot` appears.

## 4. A removed route

**Question:** After the first exercise, what does `http://localhost:8000/bonjour` return?

**Correct answer:** **c.** A 404 page.

**Explanation:** The practice route for `/bonjour` was removed. Since no remaining route matches that URL, Laravel returns 404.

## 5. A missing controller import

**Question:** If `use App\Http\Controllers\PageController;` is missing from `web.php`, what error appears?

**Correct answer:** **a.** `Target class [PageController] does not exist.`

**Explanation:** Without the import, PHP cannot resolve the short class name used in the route declaration to the controller's namespace.

## 6. Generating a named URL

**Question:** What does `route('about')` return?

**Correct answer:** **b.** `http://localhost:8000/a-propos`

**Explanation:** Laravel looks up the route named `about` and generates its absolute URL from the route's URI.

## 7. Changing a route URI but keeping its name

**Question:** If the URI `/a-propos` becomes `/about` but the route name stays `about`, what must change in the views?

**Correct answer:** **c.** Nothing.

**Explanation:** Views that link with `route('about')` use the stable route name. Laravel picks up the new URI when it generates the link.

## 8. A named title slot

**Question:** Where does text placed in `<x-slot:title>` go?

**Correct answer:** **b.** Into the layout's `$title` variable.

**Explanation:** The named slot provides the `title` value, which the layout can render in the HTML `<title>` element.

## 9. A missing Vite manifest

**Question:** A page reports “Vite manifest not found.” What is the most likely cause in the codelab setup?

**Correct answer:** **a.** `composer run dev` is not running in Terminal 1.

**Explanation:** The development command starts the Vite server that supplies the frontend assets. The page needs that server running during development.

## 10. Adding shared navigation

**Question:** To add a link to the navigation on every page, how many files need to be changed?

**Correct answer:** **c.** One: `layout.blade.php`.

**Explanation:** Pages use the shared `x-layout` component, so its navigation is rendered across all of them.

## 11. Resolving a view name

**Question:** Which file does `view('posts.index')` load?

**Correct answer:** **b.** `resources/views/posts/index.blade.php`

**Explanation:** Laravel converts dots in a view name into directory separators and appends the Blade view filename.

## 12. A non-numeric archive year

**Question:** `/posts/archive/abc` returns 404. Which line is responsible?

**Correct answer:** **b.** `whereNumber('year')` in `web.php`; the controller is never called.

**Explanation:** The route constraint rejects `abc` before the request reaches `PostController::archive()`.

## 13. An unknown article slug

**Question:** `/posts/article-inconnu` returns 404. Why?

**Correct answer:** **a.** The URL satisfies the route constraint, but the slug is not in the posts array, so `abort(404)` runs in `show()`.

**Explanation:** The lowercase slug matches the route. The controller then checks whether the article exists and returns 404 when it does not.

## 14. An archive with no matching posts

**Question:** What does `/posts/archive/2030` return?

**Correct answer:** **c.** A page titled “Articles de 2030” with an empty list.

**Explanation:** The year is numeric, so the archive route matches. No posts have that year, but the archive page still renders with no list entries.

## 15. A route-name prefix without a dot

**Question:** In a route group, if you write `name('posts')` without the final dot, what is the list route called?

**Correct answer:** **b.** `postsindex`

**Explanation:** Laravel concatenates the group name prefix exactly as written with the route's local name `index`. The dot is not inserted automatically, so `name('posts.')` is needed to produce `posts.index`.
