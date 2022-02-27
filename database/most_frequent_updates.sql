-- UPDATE01: Update comment
UPDATE comment
  SET content='New content'
  WHERE comment_id=101;

-- UPDATE02: Update event
UPDATE event
  SET name = $name,
      image_path = $image_path,
      location = $location,
      price = $price
  WHERE event_id = $event_id;

-- UPDATE03: Update vendor
UPDATE "vendor" 
  SET name= $name,
    job = $job,
    location_id = $location_id,
    description = $description,
    image_path = $image_path
WHERE vendor_id = $vendor_id;

-- UPDATE04: Update Product
UPDATE "product" 
  SET vendor_id = $vendor_id,
    "name"= $name,
    image_path = $image_path
WHERE product_id = $product_id;

-- INSERT01: Create user
INSERT INTO "user" (first_name, last_name, email, password, role, image_path)
  VALUES ($first_name, $last_name, $email, $password, $role, $image_path)

-- INSERT02: Create Blog Post
INSERT INTO blog_post (title, image_path, content, author, editor)
 VALUES ($title, $image_path, $content, $author, $editor);

-- INSERT03: Create Comment
INSERT INTO "comment"(blog_post_id, user_id, content)
VALUES ($blog_post_id, $user_id, $content);

-- INSERT04: Create Vendor
INSERT INTO "vendor" ("name", job, location_id, description, image_path)
  VALUES ($name, $job, $location_id, $description, $image_path)

-- INSERT05: Create order
INSERT INTO "order" (event_id, user_id, date, code, number_tickets, total)
 VALUES ($event_id, $user_id, $date, $code, $number_tickets, $total);

-- INSERT06: Create event
INSERT INTO event (start_date, end_date, price, name, image_path, description, editor, location)
 VALUES ($start_date, $end_date, $price, $name, $image_path, $description, $editor, $location);

-- INSERT07: Create Product
INSERT INTO "product" (first_name, last_name, email, password, role, image_path)
  VALUES ($first_name, $last_name, $email, $password, $role, $image_path)

-- DELETE01: Delete User
DELETE FROM "user"
WHERE user_id=$user_id;

-- DELETE02: Delete Blog Post
DELETE FROM "blog_post"
WHERE blog_post_id=$blog_post_id;

-- DELETE03: 	Delete Comment
DELETE FROM "comment"
WHERE comment_id=$comment_id;

-- DELETE04: Delete Order
DELETE FROM "order"
WHERE order_id=$order_id;

-- DELETE05: 	Delete Event
DELETE FROM event
WHERE event_id = $event_id;

-- DELETE06: 	Delete Vendor
DELETE FROM "vendor"
WHERE vendor_id=$vendor_id;

-- DELETE07: 	Delete Product
DELETE FROM "product"
WHERE product_id=$product_id;