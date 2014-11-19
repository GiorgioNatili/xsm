taskkill /im chrome.exe /f

taskkill /im node.exe /f

cd "%0\..\..\.."

..\bin\nodejs\node.exe app\db\run_sync.js tmp\trial-bft.sqlite trial

echo "done"
