BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

INSERT INTO "vendor" ("name", job, location_id, description, image_path)
VALUES ('Cathi Gherardini', 'Human Resources Assistant II', 2, 'leverage clicks-and-mortar users', 'http://dummyimage.com/134x100.png/ff4444/ffffff');

INSERT INTO "product" (vendor_id, name, image_path)
  VALUES (currval('vendor_vendor_id_seq'), 'batata', 'http://dummyimage.com/134x100.png/ff4444/ffffff');

COMMIT;

-- BEGIN TRANSACTION;
-- SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- INSERT INTO "vendor" ("name", job, location_id, description, image_path)
-- 	  VALUES ('zas', 'zas', 1, 'zas', 'zas');

-- INSERT INTO "product" (vendor_id, name, image_path)
--   VALUES (1, 'zas', 'zas');

-- COMMIT;