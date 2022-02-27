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

CREATE TYPE role AS ENUM ('Basic', 'Premium', 'Editor', 'Admin');

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
    dcp_id integer NOT NULL REFERENCES "district_county_parish"(dcp_id)
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