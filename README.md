# Shop

Shop plugin for Altay

### *item.yml* must be like this:

```
categories:
  Blocks:
    category-title: Blocks
    category-icon: textures/blocks/stone
    path: path
    items:
      - "1:0:1:Stone:100:path:textures/blocks/stone"
      - "2:0:1:Grass:200:path:textures/blocks/grass"
  Tools:
    category-title: Tools
    category-icon: https://raw.githubusercontent.com/undrfined/mc-icons/master/pics/276_Diamond%20Sword.png
    path: url
    items:
      - "276:0:1:Diamond Sword:1000:url:raw.githubusercontent.com/undrfined/mc-icons/master/pics/276_Diamond%20Sword.png"
      - "267:0:1:Iron Sword:500:path:textures/blocks/iron_sword"    
 ```
      
### For adding items to category:

```id:meta:count:customName:pathName|urlLink:path|url:```
