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

CREATE TABLE IF NOT EXISTS `zref_jenis_kelamin` (
  `id` tinyint NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO zref_jenis_kelamin (id, nama, deskripsi) VALUES
('01', 'Laki - Laki', null),
('02', 'Perempuan', null);



CREATE TABLE IF NOT EXISTS `pegawai` (
  `nik` bigint unsigned NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `zref_jenis_kelamin_id` tinyint NOT NULL,
  PRIMARY KEY (`nik`),
  KEY `fk_pegawai` (`zref_jenis_kelamin_id`),
  CONSTRAINT `fk_pegawai` FOREIGN KEY (`zref_jenis_kelamin_id`) REFERENCES `zref_jenis_kelamin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO pegawai (nik, nama_pegawai, tanggal_lahir, zref_jenis_kelamin_id) VALUES
(123456789, 'Ali Usman', '1990-01-24', 1),
(123456788, 'Lestari', '1992-12-01', 2);