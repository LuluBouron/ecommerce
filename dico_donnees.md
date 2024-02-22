#  Dictionnaire de données site e-commerce

Type de relation :
Product - Category = ManyToMAny


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
|description|text|NOT NULL|La description du produit|
|more_description|text|NOT NULL|L'email du produit|
|additional_infos|VARCHAR(255)|NULL|+ d'infos du produit|
|stock|INT|NOT NULL|Le stock du produit|
|solde_price|INT|NULL|Prix soldé du produit|
|regular_price|INT|NOT NULL|Prix normal du produit|
|categories|INT|NOT NULL|Catégories du produit|
|relatedProducts|INT|NOT NULL|Les produits similaires au produit|
|reviews|VARCHAR(255)|NOT NULL|Les reviews du produit|
|brand|VARCHAR(255)|NULL|La marque du produit|
|imageUrls|VARCHAR(255)|NOT NULL|L'url de l'image du produit|
|isAvailable|BOOLEAN|NOT NULL|La disponibilité du produit|
|isBestSeller|BOOLEAN|NULL|du produit|
|isNewArrival|BOOLEAN|NULL|L'email du produit|
|isFeatured|BOOLEAN|NULL|Le taux du produit|
|isSpecialOffer|BOOLEAN|NULL|Le taux du produit|
|options|TINYINT|NOT NULL|Le taux du produit|
|slug|VARCHAR(100)|NOT NULL|Le slug du produit|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création du produit|
|updated_at|TIMESTAMP|NULL|La date de la dernière mise à jour du produit|

## Category

|Champ|Type|Spécificités|Description|
|-      |-  |-  |-  |
|name|VARCHAR(255)|NOT NULL|Le nom de la catégorie|
|slug|VARCHAR(255)|NULL|Le slug de la catégorie|
|description|STRING(255)|NULL|La description de la catégorie|
|products|TINYINT|NOT NULL|Les produits de la catégorie|
|imageUrls|ARRAY|NULL|Les URLs image de la catégorie|
|isMega|BOOLEAN|NULL|L'email de la catégorie|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création de la catégorie|
|updated_at|TIMESTAMP|NULL|La date de la dernière mise à jour de la catégorie|
