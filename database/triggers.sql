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