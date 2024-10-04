<?php
// Database connection
$host = "localhost";
$dbname = "emenu";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin transaction
    $conn->beginTransaction();

    // Insert categories
    $categoryNames = ['主菜', '前菜', '甜品', '期間限定'];
    $categoryIds = [];

    foreach ($categoryNames as $name) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
        $categoryIds[$name] = $conn->lastInsertId();
    }

    // Prepare SQL for items
    $stmt = $conn->prepare("INSERT INTO items (name, price, description, image, img_type, quantity, category_id) 
                            VALUES (:name, :price, :description, :image, :img_type, :quantity, :category_id)");

    // Read image files
    $images = [
        
        ['name' => '烤肋眼牛排', 'price' => 298.00, 'description' => '多汁嫩滑的肋眼牛排，經過精心烤製，展現出美麗的焦脆外皮和豐富的油花，確保每一口都多汁且充滿風味。搭配香滑蒜味薯蓉和時令烤蔬菜，淋上奢華的紅酒醬汁，為整道菜增添一絲奢華感。', 'file' => '../images/烤肋眼牛排.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['主菜']],
        ['name' => '香煎鮭魚配開心果香蒜醬', 'price' => 238.00, 'description' => '完美香煎的鮭魚片搭配生動的開心果香蒜醬，羅勒、烤開心果和酸甜的檸檬，創造出堅果香氣與清新風味的完美融合，完美襯托鮭魚的美味。', 'file' => '../images/香煎鮭魚配開心果香蒜醬.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['主菜']],
        ['name' => '檸檬香草烤雞', 'price' => 298.00, 'description' => '選用新鮮香草與大蒜醃製，然後慢烤至金黃色，外皮酥脆，內部鮮嫩多汁。每一口都浸潤在醇厚的黃油醬汁中，完美展現雞肉的鮮美。', 'file' => '../images/檸檬香草烤雞.jpeg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['主菜']],
        ['name' => '經典博洛尼亞千層麵', 'price' => 178.00, 'description' => '這道經典的意大利美食層層堆疊著義大利面、香濃的慢煮博洛尼亞醬，醬料由絞牛肉、豬肉及香料蔬菜製成。每一層都搭配著綿密的白醬和豐富的陳年帕瑪森起司，形成風味與口感的完美融合。', 'file' => '../images/經典博洛尼亞千層麵.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['主菜']],
        ['name' => '香煎羊排', 'price' => 250.00, 'description' => '外脆內嫩的羊排，搭配鮮迷迭香、大蒜、橄欖油香料醬汁，口感豐富。', 'file' => '../images/香煎羊排.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['主菜']],

        ['name' => '蕃茄羅勒意式烤法包', 'price' => 188.00, 'description' => '蕃茄羅勒意式烤法包是一種典型的美食，由切片和烤硬質小麥麵包製成，上面塗上大蒜，然後撒上水牛奶酪片、櫻桃番茄、羅勒、牛至、整個黑橄欖、鹽分和放置特級初榨橄欖油。', 'file' => '../images/蕃茄羅勒意式烤法包.JPG', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['前菜']],
        ['name' => '開胃併盤', 'price' => 288.00, 'description' => '香腸搭配酸奶黃瓜醬和黑橄欖；義大利冷盤，薩拉米香腸，搭配葡萄、開心果和乳酪；新鮮水果和微甜的餅乾搭配巧克力慕斯。', 'file' => '../images/開胃併盤.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['前菜']],
        ['name' => '蔓越莓核桃雞肉沙拉', 'price' => 148.00, 'description' => '蔓越莓核桃雞肉沙拉小吃是奶油雞肉沙拉的小份量，具有甜鹹風味的美妙對比。', 'file' => '../images/蔓越莓核桃雞肉沙拉.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['前菜']],
        ['name' => '脆蜂蜜火腿脆脆', 'price' => 168.00, 'description' => '甜蜂蜜和鹹味火腿的美妙組合；這款蜂蜜火腿由扁麵包餅乾、高達、火腿、條子或紅洋蔥製成，味道非常美味。', 'file' => '../images/脆蜂蜜火腿脆脆.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['前菜']],
        ['name' => '烤蝦西班牙香腸', 'price' => 168.00, 'description' => '烤蝦肉質鮮嫩多汁，能吸收醃料的風味及燒烤時的煙燻香氣，讓每一口都令人滿足。西班牙香腸帶來濃郁的香料風味，增添了豐富的辛辣感。', 'file' => '../images/烤蝦西班牙香腸.JPG', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['前菜']],
        
        ['name' => '抺茶梳乎厘班戟', 'price' => 128.00, 'description' => '使用高品質的抺茶粉，帶來濃郁的茶香和鮮豔的綠色，使每一口都充滿抺茶的醇厚風味。低糖選擇：我們的抺茶班戟不會過於甜膩，適合追求健康生活的食客。', 'file' => '../images/抺茶梳乎厘班戟.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['甜品']],
        ['name' => '士多啤梨朱古力馬卡芭菲', 'price' => 168.00, 'description' => '士多啤梨、比利時朱古力粒、朱古力軟雪糕、希臘式乳酪、棉花糖、黑糖啫喱、馬卡龍、穀物脆脆；', 'file' => '../images/士多啤梨朱古力馬卡龍巴菲.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['甜品']],
        ['name' => '稀少糖雜莓拿破崙', 'price' => 168.00, 'description' => '千層酥皮：選用新鮮現烤的千層酥皮，外層酥脆，內層柔軟。稀少糖：使用天然甜味劑，減少糖分攝入，適合健康飲食者。雜莓：新鮮的藍莓、草莓、覆盆子等，富含維生素和抗氧化劑。奶油慕斯：輕盈的香草奶油慕斯，為甜點增添絲滑口感。', 'file' => '../images/稀少糖雜莓拿破崙.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['甜品']],
        ['name' => '香蕉焦糖窩夫', 'price' => 198.00, 'description' => '唔係來自新鮮香蕉：選用成熟的香蕉，提供自然的甜味和柔軟的口感。窩夫：外脆內軟的窩夫，經典的自製配方，經過精心烘烤，金黃色澤。焦糖醬：用黃糖和奶油熬製而成的焦糖醬，濃郁香甜，為窩夫增添層次感。鮮奶油（可選）：輕盈的鮮奶油增添奶香，讓甜品更加豐富。', 'file' => '../images/香蕉焦糖窩夫.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['甜品']],
        ['name' => '火焰雪山', 'price' => 228.00, 'description' => '雪白冰淇淋：選用高品質的香草或椰子冰淇淋，口感順滑，清爽宜人。鬆軟蛋糕：底部使用輕盈的海綿蛋糕，為整道甜品提供穩定的基底。焦糖醬：自製的焦糖醬，甜而不膩，為甜品增添豐富的層次感。焦糖裝飾：用糖熬製而成的脆皮焦糖，形狀如雪山，增添視覺效果。火焰效果：使用安全的食用酒精點燃，為甜品增添炫目的火焰，讓人驚艷。', 'file' => '../images/火焰雪山.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['甜品']],

        ['name' => '冬季黑松露焗龍蝦', 'price' => 388.00, 'description' => '在寒冷的冬季，黑松露的獨特風味與新鮮的龍蝦相結合，為您帶來一場奢華的美食盛宴。我們的冬季黑松露焗龍蝦是使用當季最優質的食材，精心製作而成，旨在讓每一位顧客都能體驗到海洋的鮮美與土地的珍貴', 'file' => '../images/冬季黑松露焗龍蝦.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['期間限定']],
        ['name' => '馬卡龍聖誕樹', 'price' => 599.00, 'description' => '馬卡龍外殼：選用優質的杏仁粉和新鮮的蛋白，手工製作的馬卡龍外殼，口感酥脆，內裡柔軟，具備絕佳的嚼勁。香草奶油內餡：經典的香草味道，清新而濃郁。巧克力內餡：濃厚的巧克力風味，適合巧克力愛好者。覆盆子果醬內餡：酸甜可口的覆盆子搭配，帶來清新的口感。抹茶奶油內餡：帶有淡淡苦味的抹茶，與甜蜜的馬卡龍外殼相得益彰。', 'file' => '../images/馬卡龍聖誕樹.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['期間限定']],
        ['name' => '薑味吉士醬的聖誕方形牛角包', 'price' => 268.00, 'description' => '這個聖誕季節，為您呈獻薑味吉士醬的聖誕方形牛角包，結合了傳統與創新的美味。每一口都是節日的精髓，鬆軟的牛角包外皮包裹著香濃的薑味吉士醬，散發著溫暖的香氣。', 'file' => '../images/薑味吉士醬的聖誕方形牛角包.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['期間限定']],
        ['name' => '麋鹿雪橇迷你漢堡', 'price' => 188.00, 'description' => '這款迷你漢堡結合了新鮮的食材和獨特的風味，為您帶來一場味蕾的盛宴。每一口都充滿了豐富的層次感，適合分享或獨自享用。', 'file' => '../images/麋鹿雪橇迷你漢堡.jpg', 'img_type' => 'image/jpeg', 'quantity' => '50', 'category_id' => $categoryIds['期間限定']],
        ['name' => '聖誕雪地牛肉咖哩', 'price' => 218.00, 'description' => '冬季暖心美味，完美聖誕佳品！這款聖誕雪地牛肉咖哩，靈感來自冬季的溫暖與節日的喜慶，將帶給您一種獨特的味覺體驗。濃郁的咖哩香氣與嫩滑的牛肉相結合，讓每一口都是幸福的享受。', 'file' => '../images/聖誕雪地牛肉咖哩.jpg', 'img_type' => 'image/jpeg', 'quantity' => '100', 'category_id' => $categoryIds['期間限定']]
    ];

    foreach ($images as $image) {
        $imageData = file_get_contents($image['file']);
        if ($imageData === false) {
            throw new Exception("Failed to read image file: " . $image['file']);
        }

        // Bind parameters
        $stmt->bindParam(':name', $image['name']);
        $stmt->bindParam(':price', $image['price']);
        $stmt->bindParam(':description', $image['description']);
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':img_type', $image['img_type']);
        $stmt->bindParam(':quantity', $image['quantity']);
        $stmt->bindParam(':category_id', $image['category_id']);

        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();
    echo "Success.";
} catch (Exception $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>