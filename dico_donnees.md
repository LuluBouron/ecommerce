#  Dictionnaire de données site e-commerce


## User

|Champ|Type|Spécificités|Description|
|-      |-  |-  |-  |
|full_name|VARCHAR(255)|NOT NULL|Le nom complet de l'utilisateur|
|civility|VARCHAR(255)|NULL|La civilité de l'utilisateur|
|email|VARCHAR(255)|NOT NULL|L'email de l'utilisateur|
|password|TINYINT|NOT NULL|Le taux de remboursement|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création de l'utilisateur|
|updated_at|TIMESTAMP|NULL|La date de la dernière mise à jour de l'utilisateur|


## Product

|Champ|Type|Spécificités|Description|
|-      |-  |-  |-  |
|name|VARCHAR(255)|NOT NULL|Le nom du produit|
|description|text|NULL|La description du produit|
|more_description|text|NOT NULL|L'email du produit|
|additional_infos|VARCHAR(255)|NULL|+ d'infos du produit|
|stock|INT|NOT NULL|Le stock du produit|
|solde_price|INT|NOT NULL|Prix soldé du produit|
|regular_price|INT|NOT NULL|Prix normal du produit|
|categories|INT|NOT NULL|Prix soldé du produit|
|relatedProducts|INT|NOT NULL|Les produits similaires au produit|
|reviews|VARCHAR(255)|NOT NULL|Les reviews du produit|
|brand|VARCHAR(255)|NOT NULL|La marque du produit|
|imageUrls|VARCHAR(255)|NOT NULL|L'email du produit|
|status|TINYINT|NOT NULL|Le taux de remboursement|
|isBestSeller|VARCHAR(255)|NULL|La civilité du produit|
|isNewArrival|VARCHAR(255)|NOT NULL|L'email du produit|
|isFeatured|TINYINT|NOT NULL|Le taux de remboursement|
|isSpecialOffer|TINYINT|NOT NULL|Le taux de remboursement|
|options|TINYINT|NOT NULL|Le taux de remboursement|
|slug|VARCHAR(100)|NULL|Le slug de la pilule|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création de la pilule|
|updated_at|TIMESTAMP|NULL|La date de la dernière mise à jour de la pilule|

## Category

|Champ|Type|Spécificités|Description|
|-      |-  |-  |-  |
|name|VARCHAR(255)|NOT NULL|Le nom de la catégorie|
|slug|VARCHAR(255)|NULL|Le slug de la catégorie|
|description|TEXT|NOT NULL|La description de la catégorie|
|products|TINYINT|NOT NULL|Les produits de la catégorie|
|imageUrls|VARCHAR(255)|NOT NULL|L'email du produit|
|isMega|VARCHAR(255)|NOT NULL|L'email de la catégorie|
