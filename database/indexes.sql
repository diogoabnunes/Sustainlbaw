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