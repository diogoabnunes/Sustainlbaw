DROP TYPE IF EXISTS role CASCADE;
DROP TABLE IF EXISTS "district_county_parish" CASCADE;
DROP TABLE IF EXISTS "location" CASCADE;
DROP TABLE IF EXISTS "user" CASCADE;
DROP TABLE IF EXISTS "blog_post" CASCADE;
DROP TABLE IF EXISTS "event" CASCADE;
DROP TABLE IF EXISTS "category" CASCADE;
DROP TABLE IF EXISTS "blog_category" CASCADE;
DROP TABLE IF EXISTS "event_category" CASCADE;
DROP TABLE IF EXISTS "vendor" CASCADE;
DROP TABLE IF EXISTS "product" CASCADE;
DROP TABLE IF EXISTS "comment" CASCADE;
DROP TABLE IF EXISTS "order" CASCADE;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE role AS ENUM ('Basic', 'Premium', 'Editor', 'Admin');

-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE "district_county_parish" ( --2882
  dcp_id   SERIAL PRIMARY KEY, 
  district TEXT NOT NULL,
  county   TEXT NOT NULL,
  parish   TEXT NOT NULL
);

CREATE TABLE "location" ( --100
    location_id SERIAL PRIMARY KEY,
    address TEXT NOT NULL,
    zip_code TEXT NOT NULL,
    dcp_id integer NOT NULL REFERENCES  "district_county_parish"(dcp_id)
);

CREATE TABLE "user" ( --100
    user_id SERIAL PRIMARY KEY,
    first_name text NOT NULL,
    last_name text NOT NULL,
    email text NOT NULL CONSTRAINT user_email_uk UNIQUE,
    password text NOT NULL,
    "role" role NOT NULL DEFAULT 'Basic',
    active BOOLEAN NOT NULL DEFAULT true,
    image_path text,
    user_search TSVECTOR
);

CREATE TABLE "blog_post" ( --30
    blog_post_id SERIAL PRIMARY KEY,
    title text NOT NULL,
    image_path text NOT NULL,
    content text NOT NULL,
    publication_date timestamp NOT NULL DEFAULT now(),
    author text NOT NULL,
    editor integer NOT NULL REFERENCES "user"(user_id),
    blog_search TSVECTOR
);

CREATE TABLE "event" ( --30
    event_id SERIAL PRIMARY KEY,
    start_date timestamp NOT NULL,
    end_date timestamp NOT NULL,
    publication_date timestamp NOT NULL DEFAULT now(),
    price money NOT NULL CHECK (price > money(0.0)),
    name text NOT NULL,
    image_path text,
    description text NOT NULL,
    editor integer NOT NULL REFERENCES "user"(user_id),
    location integer NOT NULL REFERENCES "location"(location_id),
    event_search TSVECTOR,
    CHECK (end_date > start_date)
);

CREATE TABLE "category" ( --15
    category_id SERIAL PRIMARY KEY,
    name text NOT NULL UNIQUE,
    image_path text NOT NULL
);

CREATE TABLE "blog_category" ( --18
    blog_category_id integer REFERENCES "category"(category_id) ON DELETE CASCADE,
    blog_post_id integer REFERENCES "blog_post"(blog_post_id) ON DELETE CASCADE,
    PRIMARY KEY(blog_category_id, blog_post_id)
);

CREATE TABLE "event_category" ( --18
    event_category_id integer REFERENCES "category"(category_id) ON DELETE CASCADE,
    event_id integer REFERENCES "event"(event_id) ON DELETE CASCADE,
    PRIMARY KEY(event_category_id, event_id)
);

CREATE TABLE "vendor" ( --30
    vendor_id SERIAL PRIMARY KEY,
    "name" text NOT NULL,
    job text,
    location_id integer REFERENCES "location"(location_id),
    description text,
    image_path text NOT NULL,
    vendor_search TSVECTOR
);

CREATE TABLE "product" ( --100
    product_id SERIAL PRIMARY KEY,
    vendor_id integer NOT NULL REFERENCES "vendor"(vendor_id) ON DELETE CASCADE,
    "name" text NOT NULL,
    image_path text NOT NULL,
    UNIQUE(vendor_id, "name")
);

CREATE TABLE "comment" ( --100
    comment_id SERIAL PRIMARY KEY,
    blog_post_id integer NOT NULL REFERENCES "blog_post"(blog_post_id) ON DELETE CASCADE,
    user_id integer NOT NULL REFERENCES "user"(user_id),
    "content" text NOT NULL,
    date timestamp NOT NULL DEFAULT now()
);

CREATE TABLE "order" ( --30
    order_id SERIAL PRIMARY KEY,
    event_id integer NOT NULL REFERENCES "event"(event_id),
    user_id integer NOT NULL REFERENCES "user"(user_id),
    date timestamp NOT NULL DEFAULT now(),
    code text,
    number_tickets integer NOT NULL,
    total money NOT NULL DEFAULT 0 CHECK (total >= money(0.0))
);

-----------------------------------------
-- INDEXES
-----------------------------------------

-- Performance Indices
-- IDX01
CREATE INDEX event_date ON event USING btree(start_date);

-- IDX02
CREATE INDEX comments_idx ON "comment" USING btree(blog_post_id);

-- IDX03
CREATE INDEX blog_post_date ON "blog_post" USING btree(publication_date);

-- IDX04
CREATE INDEX user_role_idx ON "user" USING hash("role");

-- IDX05
CREATE INDEX dcp_district_idx ON "district_county_parish" USING hash(district); 

-- IDX06
CREATE INDEX dcp_county_idx ON "district_county_parish" USING hash(county); 

-- IDX07
CREATE INDEX blog_category_idx ON blog_category USING hash(blog_category_id);

-- IDX08
CREATE INDEX event_category_idx ON event_category USING hash(event_category_id);

-- Full-text Search Indices
-- IDX09
CREATE INDEX search_event_idx ON event USING GIST(event_search);

-- IDX10
CREATE INDEX search_blog_idx ON "blog_post" USING GIST(blog_search);

-- IDX11
CREATE INDEX search_vendor_idx ON "vendor" USING GIST(vendor_search);

-- IDX12
CREATE INDEX search_user_idx ON "user" USING GIST(user_search);

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------


-- TRIGGER01: Calculate total em que insere nova order
DROP TRIGGER IF EXISTS calculate_total ON "order";
CREATE OR REPLACE FUNCTION calculate_total() RETURNS TRIGGER AS
$BODY$
BEGIN
    NEW.total = (SELECT price 
				 FROM event
				 WHERE event.event_id = NEW.event_id) * NEW.number_tickets;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER calculate_total
    BEFORE INSERT OR UPDATE ON "order"
    FOR EACH ROW
    EXECUTE PROCEDURE calculate_total();

-- TRIGGER02: Calculate total em que da update ao evento
DROP TRIGGER IF EXISTS update_total ON "event";
CREATE OR REPLACE FUNCTION update_total() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE "order" 
        SET total = (NEW.price) * "order".number_tickets
         WHERE "order".event_id = NEW.event_id;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;    

CREATE TRIGGER update_total
    AFTER UPDATE ON event
    FOR EACH ROW
    EXECUTE PROCEDURE update_total(); 

-- TRIGGER03: Confirma que a criação do evento se realiza antes do seu começo
DROP TRIGGER IF EXISTS event_date ON "event";
CREATE OR REPLACE FUNCTION event_date() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (NEW.start_date < current_date) THEN
        RAISE EXCEPTION 'Start Date must be in the future on event %', NEW.event_id;
    END IF;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;    

CREATE TRIGGER event_date
    BEFORE INSERT OR UPDATE ON event
    FOR EACH ROW
    EXECUTE PROCEDURE event_date(); 

-- TRIGGER04: Calculate total em que insere nova order
DROP TRIGGER IF EXISTS order_start_date ON "order";
CREATE OR REPLACE FUNCTION order_start_date() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (NEW.date > (SELECT start_date 
                    FROM event
                    WHERE event.event_id = NEW.event_id)) THEN
        RAISE EXCEPTION 'Order date must be before Event date. Order_id: %; Event_id: %', NEW.order_id, NEW.event_id ;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER order_start_date
    BEFORE INSERT OR UPDATE ON "order"
    FOR EACH ROW
    EXECUTE PROCEDURE order_start_date(); 

-- TRIGGER05: Só editors e admins podem criar blog_posts e events
CREATE OR REPLACE FUNCTION verify_editor() RETURNS TRIGGER AS
$BODY$
BEGIN    
    IF ('Editor' != (SELECT "role" 
				 FROM "user"
				 WHERE NEW.editor = "user".user_id)) THEN
        RAISE EXCEPTION 'Only Users with Editor permissions';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

-- TRIGGER05: Verify if it was an editor in the blog_post 
DROP TRIGGER IF EXISTS verify_editor_blog ON blog_post;
CREATE TRIGGER verify_editor_blog
    BEFORE INSERT OR UPDATE ON blog_post
    FOR EACH ROW
    EXECUTE PROCEDURE verify_editor(); 

-- TRIGGER05: Verify if it was an editor in the event_post 
DROP TRIGGER IF EXISTS verify_editor_event ON event;
CREATE TRIGGER verify_editor_event
    BEFORE INSERT OR UPDATE ON event
    FOR EACH ROW
    EXECUTE PROCEDURE verify_editor(); 
 
 -- TRIGGER06: Full-text search - Event
CREATE OR REPLACE FUNCTION event_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    NEW.event_search = setweight(to_tsvector('english', NEW.name), 'A') || setweight(to_tsvector('english', NEW.description), 'B');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS event_search_update ON event;
CREATE TRIGGER event_search_update
    BEFORE INSERT OR UPDATE ON event
    FOR EACH ROW
    EXECUTE PROCEDURE event_search_update();

-- TRIGGER07: Full-text search - Blog Post
CREATE OR REPLACE FUNCTION blog_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    NEW.blog_search = setweight(to_tsvector('english', NEW.title), 'A') || setweight(to_tsvector('english', NEW.content), 'B');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS blog_search_update ON event;
CREATE TRIGGER blog_search_update
    BEFORE INSERT OR UPDATE ON "blog_post"
    FOR EACH ROW
    EXECUTE PROCEDURE blog_search_update();

-- TRIGGER08: Full-text search - Vendor
CREATE OR REPLACE FUNCTION vendor_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    NEW.vendor_search = setweight(to_tsvector('english', NEW.name), 'A') || setweight(to_tsvector('english', NEW.job), 'B') || setweight(to_tsvector('english', NEW.description), 'C');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS vendor_search_update ON event;
CREATE TRIGGER vendor_search_update
    BEFORE INSERT OR UPDATE ON "vendor"
    FOR EACH ROW
    EXECUTE PROCEDURE vendor_search_update();

-- TRIGGER09: Full-text search - User
CREATE OR REPLACE FUNCTION user_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    NEW.user_search = setweight(to_tsvector('english', NEW.first_name), 'A') || 
                        setweight(to_tsvector('english', NEW.last_name), 'A') || 
                        setweight(to_tsvector('english', NEW.email), 'B');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS user_search_update ON "user";
CREATE TRIGGER user_search_update
    BEFORE INSERT OR UPDATE ON "user"
    FOR EACH ROW
    EXECUTE PROCEDURE user_search_update();

