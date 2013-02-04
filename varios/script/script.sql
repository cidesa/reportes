--04/02/09
/**********************PARA LAS FORMA DE REPORTES*******************************/
--CAMPOS PARA LA TABLA FORCARGOS
ALTER TABLE "forcargos"
    ADD COLUMN "canmuj" numeric(6),
    ADD COLUMN "canhom" numeric(6);


--SECUENCIA SI NO EXISTE LA TABLA
CREATE SEQUENCE forcfgrepins_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE forcfgrepins_seq OWNER TO postgres;


--SI NO EXISTE LA TABLA
CREATE TABLE forcfgrepins
(
  nrofor character varying(50) NOT NULL,
  descripcion character varying(1000) NOT NULL,
  tipo character varying(1) NOT NULL,
  cuenta character varying(100) NOT NULL,
  orden integer NOT NULL,
  id integer NOT NULL DEFAULT nextval('forcfgrepins_seq'::regclass),
  CONSTRAINT forcfgrepins_pkey PRIMARY KEY (id)
)
WITH (OIDS=FALSE);
ALTER TABLE forcfgrepins OWNER TO postgres;


--SI NO EXISTEN EN LA TABLA
ALTER TABLE "forcfgrepins"
    DROP COLUMN "cuenta",
    ADD COLUMN "cuenta" varchar(100),
    ADD COLUMN "descripcion" varchar(1000);


--TABLA PARA LA CONEXION DE LOS ESQUEMAS
CREATE SEQUENCE fordefesq_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE fordefesq_seq OWNER TO postgres;

CREATE TABLE fordefesq
(
  id integer NOT NULL DEFAULT nextval('fordefesq_seq'::regclass),
  ano character varying(20) NOT NULL,
  esquema character varying(20) NOT NULL,
  CONSTRAINT pk_fordefesq PRIMARY KEY (id)
)
WITHOUT OIDS;
ALTER TABLE fordefesq OWNER TO postgres;


--FUNCION PARA LOS REPORTES
CREATE OR REPLACE FUNCTION formatonum(numeric)
  RETURNS character varying AS
$BODY$
/* New function body */
DECLARE
CADENA VARCHAR(100);

BEGIN
SELECT TRIM(REPLACE(REPLACE(REPLACE(TO_CHAR($1,'999,999,999,999,999,990.99'),'.','*'),',','.'),'*',',')) INTO CADENA FROM EMPRESA;
RETURN(CADENA);
END;
$BODY$
  LANGUAGE 'plpgsql' VOLATILE;
ALTER FUNCTION formatonum(numeric) OWNER TO postgres;

--11/03/2009
CREATE SEQUENCE "SIMA001".correlativo_iva
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE "SIMA001".correlativo_iva OWNER TO postgres;


CREATE SEQUENCE "SIMA001".correlativo_islr
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE "SIMA001".correlativo_islr OWNER TO postgres;

CREATE SEQUENCE "SIMA001".correlativo_ltf
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE "SIMA001".correlativo_ltf OWNER TO postgres;
--12/03/2009
CREATE OR REPLACE FUNCTION instr(character varying, character varying, integer, integer)
  RETURNS integer AS
$BODY$
DECLARE
  string ALIAS FOR $1;
  string_to_search ALIAS FOR $2;
  beg_index ALIAS FOR $3;
  occur_index ALIAS FOR $4;
  pos integer NOT NULL DEFAULT 0;
  occur_number INTEGER NOT NULL DEFAULT 0;
  temp_str VARCHAR;
  beg INTEGER;
  i INTEGER;
  length INTEGER;
  ss_length INTEGER;
BEGIN
  IF beg_index > 0 THEN
     beg := beg_index;
     temp_str := substring(string FROM beg_index);

     FOR i IN 1..occur_index LOOP
         pos := position(string_to_search IN temp_str);

         IF i = 1 THEN
            beg := beg + pos - 1;
         ELSE
            beg := beg + pos;
         END IF;

         temp_str := substring(string FROM beg + 1);
     END LOOP;

     IF pos = 0 THEN
        RETURN 0;
     ELSE
        RETURN beg;
     END IF;
  ELSE
     ss_length := char_length(string_to_search);
     length := char_length(string);
     beg := length + beg_index - ss_length + 2;

     WHILE beg > 0 LOOP
           temp_str := substring(string FROM beg FOR ss_length);
           pos := position(string_to_search IN temp_str);

           IF pos > 0 THEN
              occur_number := occur_number + 1;

              IF occur_number = occur_index THEN
                 RETURN beg;
              END IF;
           END IF;

           beg := beg - 1;
     END LOOP;

     RETURN 0;
  END IF;
END;
$BODY$
  LANGUAGE 'plpgsql' VOLATILE;
ALTER FUNCTION instr(character varying, character varying, integer, integer) OWNER TO postgres;
