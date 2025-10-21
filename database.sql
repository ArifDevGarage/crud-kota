CREATE TABLE IF NOT EXISTS tbl_kota
(
  kd_kota	varchar(2)	NOT NULL,
  nm_kota	varchar(55)	NOT NULL
) ENGINE=InnoDB;

INSERT INTO tbl_kota (kd_kota, nm_kota) VALUES
('01', 'Sukoharjo'),
('02', 'Karanganyar'),
('03', 'Surakarta'),
('04', 'Salatiga'),
('05', 'Semarang');

CREATE TABLE tbl_pasien 
(
  no_rm		varchar(8)	NOT NULL,
  nm_psn	varchar(88)	NOT NULL,
  sex		varchar(1)	DEFAULT NULL,
  tgl_lhr	date		DEFAULT NULL,
  kota		varchar(2)	DEFAULT NULL,
  photo		varchar(88)	DEFAULT NULL
) ENGINE=InnoDB;

ALTER TABLE tbl_pasien
  ADD PRIMARY KEY (no_rm), ADD KEY kota (kota);

ALTER TABLE tbl_kota
  ADD PRIMARY KEY (kd_kota);

ALTER TABLE tbl_pasien
  ADD CONSTRAINT pasien_kota FOREIGN KEY (kota) REFERENCES tbl_kota (kd_kota) ON UPDATE CASCADE;