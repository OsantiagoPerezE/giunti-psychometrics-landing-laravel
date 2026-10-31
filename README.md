# Giunti Psychometrics · Landing de catálogo (Versión B · Laravel)

Prueba técnica Frontend Developer. Réplica del **home** y de la página de **contacto** de la Versión A (Next.js)
implementada con Laravel: mismas secciones, misma tipografía, mismos tamaños y colores y mismo comportamiento.
Textos en italiano, datos ficticios.

> Versión A (Next.js): https://github.com/OsantiagoPerezE/giunti-psychometrics-landing-nextjs
> Este es un repositorio **separado** del de la Versión A.

**Demo en producción:**

- Versión B (Laravel): https://giunti-psychometrics-landing-larave-six.vercel.app/
- Versión A (Next.js): https://giunti-psychometrics-landing-nextjs.vercel.app/

## Desarrollo asistido por IA

Esta versión se desarrolló con asistencia de inteligencia artificial, usando
[Claude Code](https://claude.com/claude-code) (Anthropic) como herramienta de programación.

## Stack

- Laravel 12 (sin base de datos)
- Blade: layout, vistas por sección y partials para los componentes reutilizables
- Stylus con nomenclatura BEM
- jQuery: filtros, buscador, slider, menús y validación de formularios
- Laravel Mix (sustituye a Vite, que Laravel trae por defecto)

## Versiones utilizadas

| Herramienta | Versión                                           |
| ----------- | ------------------------------------------------- |
| PHP         | 8.4.27                                            |
| Composer    | 2.11.0                                            |
| Laravel     | 12.70.2                                           |
| Node        | 22.19.0                                           |
| npm         | 11.1.0                                            |
| Laravel Mix | 6.0.49 (con webpack 5.101.3, ver [notas](#notas)) |
| Stylus      | 0.64.0                                            |
| jQuery      | 3.7.1                                             |

## Instalación

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

No requiere base de datos: sesiones y caché usan archivos (`SESSION_DRIVER=file`, `CACHE_STORE=file`).

## Desarrollo

```bash
composer run dev     # servidor (http://localhost:8000) + Mix en modo watch, en una sola terminal
```

O por separado, en dos terminales:

```bash
php artisan serve    # http://localhost:8000
npm run watch        # compila Stylus y JS al guardar
```

## Build de producción

```bash
npm run build        # CSS y JS minificados y versionados en public/css y public/js
```

## Estructura

```
config/catalog.php          todos los datos ficticios (productos, categorías, temas y constructos del megamenú, banners…).
                            Es el único archivo de configuración: para lo demás (app, caché, sesión, logs) Laravel usa
                            sus valores por defecto, ajustados desde .env
app/Support/Catalog.php     reglas de precio (promoción, descuento) y formato italiano de precios y fechas
routes/web.php              rutas: home (/) y contacto (/contatti)
public/fonts/               Geist (variable, OFL) servida en local, la misma que usa la Versión A
resources/views/
  layouts/app.blade.php     estructura común (barra superior, header, footer)
  home.blade.php            ensambla las secciones del home
  contatti.blade.php        página de contacto: canales, formulario, preguntas frecuentes
  sections/                 top-bar, header, hero, catalog, promo-banners, photo-banner, mission,
                            news, help, trust-bar, footer
  partials/                 product-card, search-modal, filters-modal, contact-form, newsletter-form,
                            breadcrumb, logo, icon, social-icon
resources/stylus/
  settings/                 variables (colores, puntos de corte, alturas) y mixins (md, lg, text, hover, focus-ring…)
  base/                     reset, fuentes, utilidades y animaciones
  components/               bloques reutilizables: button, pill, chip, badge, price, modal, logo y dropdown
                            (desplegables de la barra superior y accesos rápidos del header)
  layout/                   sticky-chrome, top-bar, header, mega-menu, footer
  sections/                 hero, catalog, product (grilla, slider y tarjeta), banners, contact (ayuda,
                            página de contacto y formulario), modals
resources/js/
  app.js                    inicializa los módulos
  modules/                  catalog, product-slider, search-modal, contact-form, newsletter,
                            header (incl. megamenú), sticky-chrome, dropdown, modal, utils
```

## Convenciones de código

- **Sin comentarios en el código** (PHP, Blade, Stylus y JS): los nombres de vistas, clases BEM, módulos y
  funciones describen lo que hacen, y las decisiones de diseño se documentan en este README.
- Estilos con BEM (`.bloque__elemento--modificador`) y estados con `.is-*`; un archivo Stylus por bloque.
- Un módulo jQuery por funcionalidad en `resources/js/modules/`, inicializados desde `app.js`.
- Datos solo en `config/catalog.php`; las vistas no contienen textos de producto.

## Qué se sube al repositorio

Se versiona solo el código fuente. El `.gitignore` excluye:

- `vendor/` y `node_modules/` (se instalan con `composer install` y `npm install`).
- `public/css`, `public/js` y `public/mix-manifest.json` (se generan con `npm run build`).
- `.env` (contiene la `APP_KEY`; se crea a partir de `.env.example`).
- Sesiones, vistas compiladas, caché y logs de `storage/` y `bootstrap/cache` (solo se suben sus `.gitignore`,
  para que las carpetas existan).

## Secciones del home

1. **Barra superior** (envíos, Corporate, Aiuto y desplegable "Accesso alla piattaforma").
2. **Header**: logo, navegación (Test, Formazione, Risorse, Contatti), "Accedi" y minicart (ambos solo visuales) y buscador.
   **Megamenú "Test"** (Ambito, Temi, Costrutti): se abre con hover o con clic, se cierra con Escape, clic
   fuera, "Chiudi" o al salir (con un pequeño retraso para poder cruzar al panel). Cada opción filtra el
   catálogo del home y lleva a él; el filtro de tema o constructo aparece como chip que se puede quitar.
   "Scopri tutti i test" quita todos los filtros. En móvil y tablet sustituye a la lista del menú.
   Al hacer scroll la barra superior se pliega por completo, el header se compacta, aparece una barra de
   progreso y, en escritorio, un botón de accesos rápidos (Corporate, Aiuto y Accesso alla piattaforma).
   En móvil y tablet, menú de hamburguesa. El enlace de la sección visible se resalta.
3. **Hero**: promociona un producto del catálogo (`hero.product_id`), con su porcentaje de descuento,
   "Esplora il catalogo" y "Scopri il prodotto".
4. **Catálogo**: píldoras de categoría con "Tutti", buscador por nombre (sin distinguir mayúsculas ni
   acentos), filtros de formato y precio en un modal, contador y chips de filtros activos, y un slider de
   una fila (3 tarjetas por slide en escritorio, 2 en tablet y 1 en móvil) con flechas, puntos, teclado y
   deslizamiento táctil. Todo en el cliente, sin recargar la página. "Vedi tutto il catalogo" quita los filtros.
5. **Banners promocionales**, **banner con foto**, **misión** y **noticias**.
6. **Hai bisogno di aiuto?**: bloque que lleva a la página de contacto.
7. **Franja de confianza** y **footer** con newsletter, enlaces, redes y copyright.

## Página de contacto (`/contatti`)

Migas de pan, canales de contacto, sede, **formulario validado con jQuery** (nombre mín. 2 caracteres, email
válido, mensaje mín. 10; errores bajo cada campo al salir del campo o al enviar, resumen y foco en el primer
error; envío simulado con estado de éxito), preguntas frecuentes (`<details>`) y llamada al catálogo.

## Enlaces entre páginas

Los enlaces al catálogo funcionan desde cualquier página: llevan a `/?categoria=…#catalogo` (o `?tema=`,
`?costrutto=`, `?q=`). En el home el clic se intercepta y el catálogo se filtra sin recargar; desde otra página
se navega al home, que aplica el filtro al cargar y limpia la URL.

## Identidad visual, tipografía y responsive

| Token      | Valor     | Uso                               |
| ---------- | --------- | --------------------------------- |
| `$primary` | `#1B4F8A` | Botones, precios, enlaces         |
| `$ink`     | `#0F2D52` | Texto                             |
| `$accent`  | `#0EA5E9` | Foco, CTA y etiqueta de descuento |
| `$surface` | `#EFF6FF` | Fondo                             |

**Igual que la Versión A:** Geist (variable, 100–900) servida desde `public/fonts` con las mismas reglas
`@font-face` que genera `next/font`, incluida la fuente de respaldo "Geist Fallback" (Arial ajustado). El mixin
`text()` aplica a cada tamaño el interlineado de la escala de Tailwind (por ejemplo, 14/20, 18/28), y los
colores auxiliares (badges, errores, éxito) son los de Tailwind 4. Comparado con la Versión A a 375, 768 y
1280 px (home, `/contatti`, header compacto, megamenú, menú móvil, modales y formulario con errores):
misma altura de página y mismos estilos calculados en todos los textos. Las únicas diferencias de píxeles
vienen de las fotos, que la Versión A sirve recomprimidas con `next/image`.

Mobile first: los estilos base son los de móvil (375 px) y se amplían con los mixins `md()` (desde 768 px)
y `lg()` (desde 1280 px). La grilla de productos tiene 1, 2 y 3 columnas. Verificado sin scroll horizontal a
375, 768 y 1280 px.

## Accesibilidad

- Enlace "Vai al contenuto", `lang="it"`, jerarquía de títulos y `aria-label` en regiones y navegación.
- Foco visible en todos los elementos interactivos. Menús con Escape, slider con flechas del teclado y
  modales con `<dialog>` (foco atrapado).
- Imágenes con texto alternativo; las decorativas, vacías.
- Formulario con etiquetas, `aria-required`, `aria-invalid`, `aria-describedby` y errores anunciados.
- El color de acento no se usa como texto sobre fondo claro (contraste insuficiente).
- Hover solo en dispositivos con puntero y animaciones desactivadas con `prefers-reduced-motion`.

## Supuestos

- **Home y contacto:** esta versión replica el home y `/contatti` de la Versión A. El listado de productos
  (`/catalogo`), la ficha de producto y el carrito quedan fuera por ahora; los enlaces que llevaban allí
  apuntan al catálogo del home ("Vedi tutto il catalogo", "Scopri il prodotto", "Esplora il catalogo").
- **"Scopri di più"** en las tarjetas de curso es solo visual (no hay ficha de producto).
- **Megamenú sin listado:** en la Versión A cada opción abre `/catalogo` con su filtro; aquí filtra el
  catálogo del home con un único filtro (ámbito, tema o constructo), igual que abrir el listado con un solo
  parámetro. Por eso "Scopri tutti i test" y "Test e corsi in evidenza" llevan ambos a la sección del catálogo.
- **Minicart solo visual:** el icono del carrito está en el header, igual que en la Versión A, pero sin
  funcionalidad (no abre panel ni cuenta artículos).
- **Botón de la tarjeta:** sin carrito, "Aggiungi al carrello" confirma la acción de forma visual.
- **Sin base de datos ni backend:** los datos son ficticios y viven en `config/catalog.php`; el formulario
  y la newsletter simulan el envío.
- **Datos de contacto** ficticios (dominio reservado `example.com`) y **logo** placeholder propio.

## Mejoras propuestas

- Añadir el listado de productos (`/catalogo`) con filtros en la URL resueltos en PHP, la ficha de producto y
  el carrito con `localStorage`, como en la Versión A.
- Imágenes responsivas (`srcset` con WebP/AVIF) para reducir el peso en móvil.
- Pruebas end-to-end (Playwright) del filtrado y del formulario.

## Despliegue

- URL pública: https://giunti-psychometrics-landing-larave-six.vercel.app/
- Desplegado en **Vercel** con su runtime de contenedores (Container Runtime, en beta), siguiendo la
  [guía oficial de Laravel en Vercel](https://vercel.com/kb/guide/laravel-php-with-docker). Está conectado al
  repositorio de GitHub: cada push a `main` genera un nuevo despliegue de producción.
- Archivos del despliegue:
  - `Dockerfile`: tres etapas. Node 22 compila Stylus y JS con Laravel Mix; Composer instala las
    dependencias sin las de desarrollo; FrankenPHP con PHP 8.4 sirve la aplicación. Se usa PHP 8.4 porque
    algunos componentes de Symfony 8 de `composer.lock` lo exigen.
  - `Caddyfile`: sirve los archivos de `public/` y envía el resto de peticiones a `index.php`.
  - `.dockerignore`: excluye `.env`, `vendor`, `node_modules`, los assets compilados y las cachés locales de
    `bootstrap/cache`, que incluyen paquetes de desarrollo.
  - `vercel.json`: declara el servicio con `"runtime": "container"` y envía todas las rutas a él.
- **Variable de entorno en Vercel:** solo `APP_KEY`, generada con `php artisan key:generate --show`. El resto
  (`APP_ENV=production`, `APP_DEBUG=false`, `LOG_CHANNEL=stderr`, caché y sesión en memoria) se define en el
  `Dockerfile`.
- La etapa de Node copia también `artisan`, porque Laravel Mix detecta que está en un proyecto Laravel por
  ese archivo, y solo entonces escribe en `public/`.
- Si no recibe visitas durante 5 minutos, el contenedor se apaga y la siguiente visita tarda unos segundos
  más.

## Notas

- **webpack fijado a 5.101.3** (`overrides` en `package.json`): Laravel Mix 6 no funciona con webpack 5.107 o
  posterior (falta `webpack/lib/SizeFormatHelpers`), y con 5.106 falla la validación de opciones de
  `ProgressPlugin`. 5.101.3 compila sin errores.
- `composer run dev` usa `npx concurrently`, que se descarga la primera vez.
