SELECT DISTINCT user_id AS 'user' 
FROM order_;

SELECT id
FROM user
WHERE email = 'tkoval37@gmail.com' AND password = '1111';


SELECT name
FROM product 
WHERE name LIKE 'Sam%'
LIMIT 10
OFFSET 20;


SELECT order_.date, user.name, product.name, product.price
FROM order_
JOIN user ON user.id = order_.user_id
JOIN product ON product.id = order_.product_id AND product.price > 25000
WHERE order_.date > ('15-02-2021')
ORDER BY user.name;


SELECT name FROM user
LEFT JOIN order_ ON order_.user_id = user.id
WHERE order_.user_id IS NULL;


SELECT product.name
FROM product
UNION
SELECT category.name
FROM category
ORDER BY name


SELECT category.name AS category, COUNT(*) AS product_count
FROM category
JOIN product ON product.category_id = category.id
GROUP BY product.category_id
HAVING COUNT(*) > 0
ORDER BY product_count DESC


SELECT * FROM product
WHERE price > (SELECT AVG(price) FROM product)
ORDER BY price DESC

SELECT order_.id, order_.date,
	(SELECT product.name FROM product
    WHERE product.id = order_.product_id) AS product
FROM order_
ORDER BY order_.id DESC
LIMIT 5