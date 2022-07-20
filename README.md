# CrashBanUsers
Upon onPlayerLogin, crash-banned user's clients will be crashed.

__**How it works:**__
Basically if the y coordinate ≃ `-2,147,483,648` (Min x32 Signed Int) or `2,147,483,647` (Max x32 Signed Int), the client will crash.
After inspiration from [Jason's Plugin](https://github.com/jasonwynn10/CrashAndBan/), I've made this feature plugin of its own.
This plugin is different, seeing as the fact that `$sender` is also able to unban the player via command, also (within the `crash-banned-users.json` file it tells you who banned the player. 

## Usage: 

| Command                | Description       | Alias(es)            | Permission                  |
| ---------------------- | ----------------- | -------------------- | --------------------------- |
| `/crashban <player>`   | Bans the player   | cban                 | crashbanusers.command.ban   |
| `/crashunban <player>` | Unbans the player | cpardon, crashpardon | crashbanusers.command.unban |

## How do I unban a player manually?
This shouldn't be necessary, as `/crashunban` already does the advanced option already, but it's here so you know what to do if you're bored. Just don't come running to me when there are issues.  

1. In `plugin_data/CrashBanUsers/crash-banned-users.json`, delete the user's name.
2. In the `players/` directory, search for the player's name, and do either one of the following:
    - (Easiest Option - Deletes their data:) Delete the player's `.dat` file
    - (Advanced Option:) Head to your favourite NBT Editor (For example, https://irath96.github.io/webNBT/ or https://github.com/jaquadro/NBTExplorer). Head to "Pos", and change the integers to any coordinate of your choice, so long as it's sensible. 

## Plugin's Inspiration:
- I was playing around and found out (with help from @JavierLeon9966) that (in this case) the height integer was 32bit signed. 
- https://github.com/jasonwynn10/CrashAndBan - Jason's CrashAndBan Plugin (which is currently archived)
