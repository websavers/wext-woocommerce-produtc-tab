# Websavers WooCommerce Product Tab

The original plugin, wext-woocommerce-product-tab hadn't been maintained in years and doesn't support respecting WooCommerce product visibility settings among other useful settings.

Version 1.5 includes the following changes:
- Move settings pane to show under WooCommerce menu rather than occupy its own space in the main WordPress admin menu
- Add settings for number of product columns, display prefix text for categories, and exclude categories by CSV category IDs
- Auto exclude uncategorized category
- Only show products set to "Catalog" visibility (respect WooCommerce product settings)
- Fix typos
- Remove forced font styling. This should be set by the theme.
- Set the title of the product to H2 heading, not the price (should be better for SEO and theme compatibility)
- Link image and title to product
- Replace WordPress post queries with WooCommerce product queries, should be much better long-term
