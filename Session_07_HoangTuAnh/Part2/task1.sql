SELECT products.name, categories.category_name
FROM products
LEFT JOIN categories ON products.category_id = categories.id;