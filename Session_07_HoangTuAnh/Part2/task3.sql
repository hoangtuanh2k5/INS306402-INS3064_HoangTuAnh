SELECT users.name,
       users.email,
       SUM(orders.total_amount) AS total_spent
FROM users
JOIN orders ON users.id = orders.user_id
GROUP BY users.id, users.name, users.email
ORDER BY total_spent DESC
LIMIT 3;