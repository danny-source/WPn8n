# WP n8n

## 插件資訊
- 貢獻者：Danny
- 標籤：n8n, workflow, automation, demo, webcomponent, shortcode, integration
- 最低需求：WordPress 5.2
- 測試版本：6.4
- 穩定版本：1.0.1
- PHP 需求：7.2
- 授權：GPLv2 或更新版本
- 授權網址：https://www.gnu.org/licenses/gpl-2.0.html

**使用簡單的 shortcode 直接在 WordPress 文章、頁面和評論中嵌入互動式 n8n 工作流程演示。**

WP n8n 是一個強大的 WordPress 插件，可將 n8n 工作流程演示無縫整合到您的 WordPress 網站中。無論您是在編寫自動化工作流程文檔、展示整合範例，還是創建教學，這個插件都能讓您輕鬆顯示互動式 n8n 工作流程演示，讓訪客直接在您的網站上探索。

## 功能說明

WP n8n 是一個專注於 n8n 工作流程演示的 WordPress 插件。它可以讓您在文章、頁面和評論中嵌入互動式的 n8n 工作流程演示，讓讀者能夠直接在您的網站上查看和互動 n8n 工作流程。

### 主要功能

* **簡單的 Shortcode 整合** - 使用 `[n8n]...[/n8n]` shortcode 在內容中任何地方嵌入工作流程
* **互動式工作流程演示** - 訪客可以直接在您的網站上與 n8n 工作流程互動
* **通用相容性** - 適用於文章、頁面、小工具和評論
* **自動資源載入** - 自動從 CDN 載入所有必需的 JavaScript 函式庫
* **安全優先** - 驗證並清理所有工作流程 JSON 以防止 XSS 攻擊
* **零配置** - 開箱即用，無需設定
* **輕量級** - 對效能影響最小，僅在需要時載入資源
* **Gutenberg 就緒** - 與 Classic 和 Gutenberg 編輯器無縫配合
* **管理設定頁面** - 包含有用的設定頁面，提供使用範例和文檔

### 技術特性

* JSON 格式驗證
* HTML 實體編碼以防止 XSS
* 使用 WordPress `esc_attr()` 函數進行安全轉義
* 無效 JSON 的優雅錯誤處理
* 支援在同一頁面上使用多個工作流程
* 與快取插件相容
* 多站點相容

### 適用場景

**完美適用於：**
* 技術文檔網站
* 自動化和整合教學
* SaaS 產品文檔
* 開發者部落格
* 工作流程展示頁面
* API 文檔
* 整合指南

## 安裝說明

### 自動安裝

1. 登入您的 WordPress 管理後台
2. 前往「外掛 > 安裝外掛」
3. 搜尋「WP n8n」
4. 點擊「立即安裝」，然後點擊「啟用」

### 手動安裝

1. 下載插件 ZIP 檔案
2. 登入您的 WordPress 管理後台
3. 前往「外掛 > 安裝外掛 > 上傳外掛」
4. 選擇 ZIP 檔案並點擊「立即安裝」
5. 點擊「啟用外掛」

### 透過 FTP 安裝

1. 解壓縮插件 ZIP 檔案
2. 將 `WPn8n` 資料夾上傳到 `/wp-content/plugins/` 目錄
3. 登入您的 WordPress 管理後台
4. 前往「外掛」
5. 找到「WP n8n」並點擊「啟用」

啟用後，請前往「設定 > WP n8n」查看使用指南和範例。

## 使用說明

### 基本範例

在您的文章、頁面或評論中，使用 WordPress shortcode：

```
[n8n]
{
  "nodes": [
    {
      "name": "Webhook",
      "type": "n8n-nodes-base.webhook",
      "position": [250, 300],
      "parameters": {
        "path": "webhook",
        "httpMethod": "POST"
      },
      "typeVersion": 1
    },
    {
      "name": "Set",
      "type": "n8n-nodes-base.set",
      "position": [450, 300],
      "parameters": {},
      "typeVersion": 1
    }
  ],
  "connections": {
    "Webhook": {
      "main": [
        [
          {
            "node": "Set",
            "type": "main",
            "index": 0
          }
        ]
      ]
    }
  }
}
[/n8n]
```

### 完整工作流程範例

```
[n8n]
{
  "nodes": [
    {
      "name": "開始",
      "type": "n8n-nodes-base.webhook",
      "position": [240, 300],
      "parameters": {
        "path": "demo",
        "httpMethod": "GET"
      },
      "typeVersion": 1
    },
    {
      "name": "HTTP 請求",
      "type": "n8n-nodes-base.httpRequest",
      "position": [460, 300],
      "parameters": {
        "url": "https://api.example.com/data",
        "method": "GET"
      },
      "typeVersion": 1
    },
    {
      "name": "設定",
      "type": "n8n-nodes-base.set",
      "position": [680, 300],
      "parameters": {
        "values": {
          "string": [
            {
              "name": "message",
              "value": "來自 n8n 的問候！"
            }
          ]
        }
      },
      "typeVersion": 1
    }
  ],
  "connections": {
    "開始": {
      "main": [
        [
          {
            "node": "HTTP 請求",
            "type": "main",
            "index": 0
          }
        ]
      ]
    },
    "HTTP 請求": {
      "main": [
        [
          {
            "node": "設定",
            "type": "main",
            "index": 0
          }
        ]
      ]
    }
  }
}
[/n8n]
```

### 替代語法

您也可以使用 workflow 屬性來傳遞單行 JSON：

```
[n8n workflow='{"nodes":[...],"connections":{}}']
```

### 運作方式

插件會自動：
1. 載入必要的 JavaScript 資源（Web Components Loader、Lit polyfill、n8n-demo-component）
2. 驗證 JSON 格式
3. 清理內容以防止 XSS 攻擊
4. 將 shortcode 轉換為 `<n8n-demo workflow='...'></n8n-demo>` Web Component
5. 在前端渲染互動式 n8n 工作流程演示

## 如何取得工作流程 JSON

1. 在 n8n 中開啟您的工作流程（本地或雲端）
2. 點擊右上角的三點選單（⋮）
3. 選擇「下載」或「匯出」
4. 在文字編輯器中開啟下載的 JSON 檔案
5. 複製整個 JSON 內容
6. 將其貼到 WordPress 內容中的 `[n8n]...[/n8n]` shortcode

## 安全性

插件遵循 WordPress 安全最佳實踐：

* **JSON 驗證** - 所有工作流程 JSON 在渲染前都會經過驗證
* **XSS 防護** - HTML 實體編碼可防止跨站腳本攻擊
* **WordPress 函數** - 使用 WordPress 內建清理函數（`esc_attr()`）
* **錯誤處理** - 無效的 JSON 會被安全地替換為錯誤註解
* **無資料收集** - 插件不會收集或儲存任何用戶資料
* **CDN 資源** - 僅從官方 CDN 載入受信任的資源

## 常見問題

### 什麼是 n8n？

n8n 是一個強大的工作流程自動化工具，可讓您連接不同的服務並自動化任務。此插件可讓您在 WordPress 網站上展示 n8n 工作流程。

### 我需要 n8n 帳號才能使用這個插件嗎？

不需要，您不需要活躍的 n8n 帳號。您只需要從 n8n 匯出的工作流程 JSON 檔案。但是，您需要 n8n 來創建或編輯工作流程。

### 我可以與 Gutenberg 區塊一起使用嗎？

可以！您可以在 Gutenberg 中使用 Shortcode 區塊，並貼上您的 `[n8n]...[/n8n]` shortcode。或者，您可以使用 Classic 區塊或任何支援 shortcode 的區塊。

### 這個插件會影響我現有的內容嗎？

不會。插件只會在顯示內容時處理 shortcode。您的原始內容在資料庫中保持完全不變。您可以安全地停用或卸載插件而不會丟失任何內容。

### 這個插件可以與頁面建構器一起使用嗎？

可以，插件可與任何支援 WordPress shortcode 的頁面建構器一起使用，包括 Elementor、Beaver Builder、Divi 等。只需新增 shortcode 小工具/模組並貼上您的 `[n8n]...[/n8n]` shortcode。

### 這個插件安全嗎？

是的。插件遵循 WordPress 安全最佳實踐：
* 驗證所有 JSON 輸入以確保格式正確
* 使用 WordPress 內建函數（`esc_attr()`）清理內容
* 透過適當的 HTML 實體編碼防止 XSS 攻擊
* 無效的 JSON 會被安全地替換為錯誤註解，而不是破壞您的網站

### 這個插件會收集用戶資料嗎？

不會。插件不會收集、儲存或傳輸任何用戶資料。它只會從 CDN 載入 n8n-demo-webcomponent 函式庫來渲染工作流程。

### 我可以在同一頁面上使用多個工作流程嗎？

可以！您可以在同一頁面上多次使用 `[n8n]...[/n8n]` shortcode，每個都可以是不同的工作流程。

### 如果我貼上無效的 JSON 會發生什麼？

插件會驗證 JSON 格式。如果無效，它會顯示一個 HTML 註解，其中包含錯誤訊息（僅在頁面原始碼中可見），並跳過渲染該特定工作流程。您的頁面將繼續正常載入。

### 這個插件可以與快取插件一起使用嗎？

可以，插件與快取插件相容。但是，如果您使用積極的快取，在新增或修改工作流程後可能需要清除快取。

### 工作流程大小有限制嗎？

插件沒有強制執行硬性限制，但非常大的工作流程可能會影響頁面載入時間。建議保持工作流程大小合理，以獲得最佳用戶體驗。

### 這個插件可以與多站點一起使用嗎？

可以，插件與 WordPress 多站點安裝相容。您可以網路範圍啟用或按站點啟用。

## 更新日誌

### 1.0.1
* **增強功能**：從代碼區塊語法改為 WordPress shortcode 語法，提升相容性
* **改進**：增強 shortcode 處理器以支援屬性和內容式工作流程 JSON
* **改進**：更好的無效 JSON 錯誤處理
* **文檔**：更新所有文檔和範例以反映 shortcode 使用方式

### 1.0.0
* **初始發布**
* 支援 WordPress shortcode `[n8n]...[/n8n]` 嵌入工作流程
* 自動載入 n8n-demo-webcomponent 函式庫
* JSON 驗證和清理以確保安全
* 管理設定頁面和使用範例
* 支援文章、頁面和評論
* Gutenberg 和 Classic 編輯器相容性
* 輕量級實現，對效能影響最小

## 升級通知

### 1.0.1
此更新將語法從代碼區塊改為 WordPress shortcode。如果您使用的是先前的代碼區塊語法，請更新您的內容以使用 `[n8n]...[/n8n]` shortcode 格式。這提供了與 WordPress 編輯器和頁面建構器更好的相容性。

### 1.0.0
初始發布。立即開始在您的 WordPress 內容中嵌入互動式 n8n 工作流程演示！

## 致謝

本插件使用由 n8n.io 開發的 n8n-demo-webcomponent 函式庫。

**n8n-demo-webcomponent**
* 版權所有 (c) n8n.io
* 網站：https://n8n.io/
* 元件文檔：https://n8n-io.github.io/n8n-demo-webcomponent/

**n8n**
* n8n 是一個強大的工作流程自動化工具
* 網站：https://n8n.io/
* 文檔：https://docs.n8n.io/

## 支援

如需支援、功能請求或錯誤報告：
* WordPress.org 支援論壇：https://wordpress.org/support/plugin/wp-n8n/

## 隱私權

此插件：
* 不收集任何個人資料
* 不儲存任何用戶資訊
* 不追蹤用戶行為
* 僅在顯示工作流程時從 CDN 載入外部資源（n8n-demo-webcomponent）
* 所有處理都在您的伺服器上本地完成

## 授權

本插件採用 GPL v2 或更新版本授權。

此程式是免費軟體；您可以根據自由軟體基金會發布的 GNU 通用公共許可證的條款重新分發和/或修改它；許可證的第 2 版，或（由您選擇）任何更高版本。

此程式是希望它有用而分發的，但沒有任何保證；甚至沒有適銷性或特定用途適用性的隱含保證。有關更多詳細資訊，請參閱 GNU 通用公共許可證。
