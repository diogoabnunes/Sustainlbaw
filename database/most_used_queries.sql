-- SELECT01: Login
SELECT user_id, email, password
FROM "user"
WHERE email = 'kvicary3@soup.io'
	AND password = 'PAtuLSmpfbQF' AND active=true;

-- SELECT02: User profile
SELECT first_name, last_name, role, image_path
FROM "user"
WHERE user_id = 13;

-- SELECT03: Main Blog posts
SELECT * FROM blog_post
ORDER BY publication_date DESC
LIMIT 10 --OFFSET 10;

-- SELECT04: Main Events
SELECT * FROM "event"
ORDER BY start_date DESC
LIMIT 6 --OFFSET 6;

-- SELECT05: Blog post comments
SELECT user_id, comment_id, first_name, last_name, content, date, image_path
FROM comment NATURAL JOIN "user"
WHERE blog_post_id = 13;

-- SELECT06: Filter Blog posts by category
SELECT category_id, category AS category_name,
    blog_post.blog_post.id, publication_date, title, content, blog_post.image_path, blog_post.author, blog_post.editor
FROM blog_post
    JOIN blog_category ON blog_post.blog_post_id = blog_category.blog_post_id
    JOIN category ON category_id = blog_category_id
WHERE category_id = 2;

-- SELECT07: Filter Events by category
SELECT category_id, category AS category_name,
    event.event_id AS event_id,Event.start_date, end_date, publication_date, price, Event.name, Event.image_path, Event.description, location
FROM event
	JOIN event_category ON event.event_id = event_category.event_id
	JOIN category ON category_id = event_category_id
WHERE category_id = 2;

-- SELECT08: Get vendor
SELECT *
FROM vendor NATURAL JOIN location NATURAL JOIN district_county_parish
WHERE vendor_id = 13;

-- SELECT09: Vendor products
SELECT * FROM product 
JOIN vendor ON vendor.vendor_id = product.vendor_id
WHERE vendor.vendor_id = 30;

-- SELECT10: Current week events
SELECT * FROM event
WHERE start_date
    BETWEEN
        now() AND 
        current_date + 7
ORDER BY start_date; 

-- SELECT11: Next week events
SELECT * FROM event
WHERE start_date
    BETWEEN
        current_date + 7 AND 
        current_date + 14
ORDER BY start_date;

-- SELECT12: Current month events
SELECT * FROM event
WHERE start_date
    BETWEEN
        now() AND 
        current_date + 31
ORDER BY start_date; 

-- SELECT13: Counting number of orders of an Event
SELECT COUNT(*) FROM "order" WHERE event_id = $event_id;

-- SELECT14: Events from last month
SELECT * FROM "blog_post"
WHERE publication_date
    BETWEEN
        current_date - 31 AND 
        now()
ORDER BY publication_date; 

SELECT * FROM "user" 
WHERE "role" = 'Admin';


-- SELECT15: Select all locations in district
SELECT location_id, address, zip_code,
	district, county, parish,
	district_county_parish.dcp_id
FROM "location" NATURAL JOIN district_county_parish
WHERE district = $district
order by location_id;


-- SELECT16: Select user from type
SELECT * FROM "user" 
WHERE "role" = $role;

-- SELECT17: Searching for event
SELECT event_id,name,start_date,end_date,price, location,description, ts_rank_cd(event_search, plainto_tsquery('english', $query)) AS rank
FROM event
WHERE event_search @@ plainto_tsquery('english', $query)
AND start_date >= current_date
ORDER BY rank DESC;


-- SELECT18: Searching for a blog post
SELECT blog_post_id, title, content, publication_date, author, editor, image_path, ts_rank_cd(blog_search, plainto_tsquery('english', $query)) AS rank
FROM event
WHERE blog_search @@ plainto_tsquery('english', $query)
ORDER BY rank DESC;


-- SELECT19: Searching for a vendor
SELECT vendor_id, name, job, location_id, description, image_path, ts_rank_cd(vendor_search, plainto_tsquery('english', $query)) AS rank
FROM "vendor"
WHERE vendor_search @@ plainto_tsquery('english', $query)
ORDER BY rank DESC;


-- SELECT20: Searching for a user
SELECT user_id, first_name, last_name, email, "role", image_path, ts_rank_cd(user_search, plainto_tsquery('english', $query)) AS rank
FROM "user"
WHERE user_search @@ plainto_tsquery('english', $query)
ORDER BY rank DESC;


------------------------ LOCATION --------------------------


SELECT location_id, address, zip_code,
	district, county, parish,
	district_county_parish.dcp_id
FROM "location" NATURAL JOIN district_county_parish
WHERE district = 'Porto'
order by location_id;

SELECT county
FROM district_county_parish
WHERE district = 'Porto';

-- QUERIES ----------------------------------------------

-- Query for event
SELECT event_id,name,start_date,end_date,price, location,description, ts_rank_cd(event_search, plainto_tsquery('english', 'Sustentável')) AS rank
FROM event
WHERE event_search @@ plainto_tsquery('english', 'Sustentável') AND
start_date >= current_date
ORDER BY rank DESC;

-- Query for blog post
SELECT blog_post_id, title, content, publication_date, author, editor, image_path, ts_rank_cd(blog_search, plainto_tsquery('english', 'Sustentável')) AS rank
FROM event
WHERE blog_search @@ plainto_tsquery('english', 'Sustentável')
ORDER BY rank DESC;

-- Query for vendor
SELECT vendor_id, name, job, location_id, description, image_path, ts_rank_cd(vendor_search, plainto_tsquery('english', 'web')) AS rank
FROM "vendor"
WHERE vendor_search @@ plainto_tsquery('english', 'web')
ORDER BY rank DESC;

-- Query for user
SELECT user_id, first_name, last_name, email, "role", image_path, ts_rank_cd(user_search, plainto_tsquery('english', 'Flori')) AS rank
FROM "user"
WHERE user_search @@ plainto_tsquery('english', 'Flori')
ORDER BY rank DESC;