# CLAUDE.md — NLG Inventory Dashboard

## Project
Product inventory management dashboard built for a **Full Stack Developer technical test**
(PT Niagamas Lestari Gemilang — an industrial tools & machinery distributor).
Single-entity CRUD app with external API sync, an internal JSON API, and a clean
industrial UI (light + dark). Must be deployed to a public URL.

## Stack
- **Laravel** (latest, 12/13) + **Blade** templates, PHP 8.2+
- **Tailwind CSS v4** (via `@tailwindcss/vite`) + Vite
- **SQLite** for local dev (Laravel default), **MySQL** on Railway
- Deploy target: **Railway** (public URL required)
- No frontend framework — Blade + Tailwind only. Minimal vanilla JS (dark-mode toggle).

## Requirements (from the test brief)
1. **Product CRUD** — entity `Product` with fields: id, name, price, stock, description.
   Full create / read / update / delete with **validation**. List in a **table with pagination**.
2. **External API sync** — fetch from `https://fakestoreapi.com/products`; a **"Sync Products"**
   button imports products into the local DB.
3. **Internal API** — `GET /api/products` returns the local product list as **JSON**.
4. **Frontend** — Tailwind, responsive, at least one **dashboard page** with the product list,
   CRUD actions, and the Sync button.
5. **Deploy** — public running URL on Railway, accessible to everyone.

## Data model (ERD — single table)
`products`
- `id` — bigint, PK, auto-increment
- `name` — string, required            (maps from fakestore `title`)
- `price` — decimal(12,2), required
- `stock` — unsigned int, default 0     (fakestore has no stock -> generate on sync)
- `description` — text, nullable
- `external_id` — string, nullable, **unique**  (fakestore id -> makes sync idempotent)
- timestamps

Optional stretch (only if core is done + deployed): a `categories` table with
`products.category_id` (Product belongsTo Category), populated from fakestore `category`.

## Architecture & conventions

### Controllers — grouped by domain
Everything product-related lives under a `Product/` folder:
- `app/Http/Controllers/Product/ProductController.php`         -> web CRUD + `sync()`
- `app/Http/Controllers/Api/Product/ProductApiController.php`  -> `GET /api/products` (JSON)
- Web controllers are grouped by domain (`Product/`); **API controllers live under a
  separate `Api/` folder, then grouped by domain** (`Api/Product/`).
- Namespaces: web = `App\Http\Controllers\Product`, api = `App\Http\Controllers\Api\Product`.
- FormRequests grouped the same way, under `app/Http/Requests/Product/`:
  `StoreProductRequest`, `UpdateProductRequest` — validation lives here, never inline.
- Routes reference the namespaced classes, e.g.
  `Route::resource('products', \App\Http\Controllers\Product\ProductController::class);`
  plus `POST /products/sync`. `/` redirects to `/products`.

### Service layer
- `app/Services/FakeStoreService.php` encapsulates the HTTP fetch + mapping (Laravel `Http` client).
- Sync is **idempotent**: `updateOrCreate` keyed on `external_id` (never duplicate on re-sync).
- Pagination via Eloquent `paginate()`; preserve the search query across paginator links.
- Right-align numeric columns (price, stock). Real API data — no lorem ipsum.

### Views — COMPONENT-BASED (Blade components, not partials)
Build the UI from reusable Blade components using `<x-...>` syntax. Prefer **anonymous
components**; use class-based (`app/View/Components/`) only when PHP logic is needed.
- `resources/views/components/layouts/app.blade.php`  -> `<x-layouts.app>` (nav + dark toggle + slot)
- `resources/views/components/ui/`  -> reusable primitives:
  `button`, `input`, `textarea`, `badge` (stock status), `card`, `table`, `pagination`
  used as `<x-ui.button>`, `<x-ui.badge>`, etc.
- `resources/views/components/product/`  -> domain components:
  `<x-product.table>`, `<x-product.form>` (shared by create + edit), `<x-product.row>`
- Pages stay thin and just compose components:
  `resources/views/products/{index,create,edit}.blade.php`

### Styling — NO inline CSS
- **Never** use `style="..."` attributes or `<style>` blocks inside Blade.
- Style with **Tailwind utility classes** directly in the markup.
- When a custom or repeated style is needed, define it as a component class in
  `resources/css/app.css` using `@layer components { .name { @apply ...; } }`,
  then reference it by **class name** in the Blade markup.
- All CSS stays in CSS files (`resources/css/app.css`). Blade only carries class names.

## Suggested folder structure
```
app/Http/Controllers/Product/ProductController.php        # web CRUD + sync()
app/Http/Controllers/Api/Product/ProductApiController.php # GET /api/products (JSON)
app/Http/Requests/Product/StoreProductRequest.php
app/Http/Requests/Product/UpdateProductRequest.php
app/Models/Product.php
app/Services/FakeStoreService.php
app/View/Components/...                                    # class-based components (only if logic needed)
database/migrations/xxxx_create_products_table.php
database/factories/ProductFactory.php                     # optional dummy data
resources/views/components/layouts/app.blade.php          # <x-layouts.app>
resources/views/components/ui/button.blade.php            # <x-ui.button>
resources/views/components/ui/input.blade.php
resources/views/components/ui/textarea.blade.php
resources/views/components/ui/badge.blade.php             # stock status badge
resources/views/components/ui/card.blade.php
resources/views/components/ui/table.blade.php
resources/views/components/ui/pagination.blade.php
resources/views/components/product/table.blade.php        # <x-product.table>
resources/views/components/product/form.blade.php         # <x-product.form> (create + edit)
resources/views/products/index.blade.php                  # toolbar (search + Sync) + <x-product.table>
resources/views/products/create.blade.php
resources/views/products/edit.blade.php
resources/css/app.css                                     # Tailwind v4 @theme tokens + @layer components
routes/web.php
routes/api.php
```

## Design system  (from Claude Design)
Source of truth: the Claude Design export dropped into `design/` in the repo root
(HTML + Tailwind token snippet). Honor it exactly. Aesthetic: **industrial, functional,
high-contrast, data-first** — clean like Linear / Stripe / Vercel.
**No glassmorphism, no heavy gradients, no glow.** Modest radius (~6px). Depth from thin
borders + subtle shadow only.

- **Brand:** red wordmark "NLG". Primary red `#D42A22` (light) / `#F0433A` (dark).
- **Neutrals — light:** bg `#FAFAFA`, surface `#FFFFFF`, border `#E4E4E7`, text `#18181B`, muted `#71717A`.
- **Neutrals — dark:** bg `#0A0A0A`, surface `#18181B`, border `#27272A`, text `#FAFAFA`, muted `#A1A1AA`.
- **Semantic (stock badge):** green = in stock, amber = low stock, red = out of stock
  (use dark-adjusted variants on dark surfaces so badges stay legible).
- **Type:** headings **Archivo**, body/UI **Inter**.
- **Dark mode:** first-class. Implement via Tailwind's class strategy (`dark:` variant) + a toggle.

**Tailwind v4 note:** this Laravel install uses Tailwind v4, which configures via CSS, not
`tailwind.config.js`. Port the design system's tokens into a `@theme` block inside
`resources/css/app.css`, and set up the class-based `dark` variant there. Turn recurring
component styles into `.classes` under `@layer components` (via `@apply`) so Blade only
references class names.

## Guardrails
- Keep scope honest and shippable: **core requirements + deploy first**, stretch goals only if time allows.
- Don't over-engineer. Match the design system; don't invent a flashier style.