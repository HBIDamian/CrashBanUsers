# CrashBanUsers
Upon onPlayerLogin, crash banned user's clients will be crashed.

## How do I unban a player?
1. In `plugin_data/CrashBanUsers/crash-banned-users.json`, delete the user's name.
2. In the `players/` directory, search for the player's name, and do either one of the following:
    - (Easiest Option - Deletes their data:) Delete the player's `.dat` file
    - (Advanced Option:) Head to your favourite NBT Editor (For example, https://irath96.github.io/webNBT/ or https://github.com/jaquadro/NBTExplorer). Head to "Pos", and change the integers to any coordinate of your choice, so long as it's sensible. 

## Plugin's Inspiration:
- I was playing around and found out (with help from @JavierLeon9966) that (in this case) the height integer was 32bit signed. 
- https://github.com/jasonwynn10/CrashAndBan - Jason's CrashAndBan Plugin (which is currently archived)
