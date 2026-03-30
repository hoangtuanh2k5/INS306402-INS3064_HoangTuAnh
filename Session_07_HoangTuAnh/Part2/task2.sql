SELECT categories.category_name,
       SUM(order_items.quantity * order_items.unit_price) AS total_revenue
FROM order_items
JOIN products ON order_items.product_id = products.id
LEFT JOIN categories ON products.category_id = categories.id
GROUP BY categories.id, categories.category_name;