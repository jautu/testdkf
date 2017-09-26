INSERT INTO `company` (`id`, `name`)
VALUES
	(1,'Empresa 01 test'),
	(2,'Empresa 02'),
	(3,'Empresa 03'),
	(4,'Empresa 04');

INSERT INTO `relation` (`id`, `name`)
VALUES
	(1,'Cliente'),
	(2,'Proveedor');

INSERT INTO `agreement` (`id`, `company_id`, `name`)
VALUES
	(1,1,'Acuerdo 01'),
	(2,2,'Acuerdo 02');

INSERT INTO `company_relation` (`id`, `agreement_id`, `company_id`, `relation_id`)
VALUES
	(1,1,2,1),
	(2,1,3,2),
	(3,1,4,2),
	(4,2,1,1),
	(5,2,3,1),
	(6,2,4,2);
