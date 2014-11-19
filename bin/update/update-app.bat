taskkill /im chrome.exe /f

taskkill /im node.exe /f



cd "%0\..\..\.."


..\bin\Git\bin\git.exe fetch --all
..\bin\Git\bin\git.exe reset --hard origin/master

call node_modules\.bin\bower update


call ..\bin\nodejs\npm update


echo "done"
