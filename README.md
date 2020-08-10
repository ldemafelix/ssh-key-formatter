# SSH Key Formatter

This tool allows you to make `wget`-able (or `curl`-able) cron jobs that automatically writes your `~/.ssh/authorized_keys` file with the public keys you have on GitHub or GitLab.

# Usage

On a cron job, you could do:

```
# For GitHub
0 0 * * * /usr/bin/wget https://your.app/keys.php?source=github&username=yourusername" -O ~/.ssh/authorized_keys && chmod 0600 ~/.ssh/authorized_keys

# For GitLab (on GitLab.com)
0 0 * * * /usr/bin/wget https://your.app/keys.php?source=gitlab&username=yourusername" -O ~/.ssh/authorized_keys && chmod 0600 ~/.ssh/authorized_keys

# For GitLab (self-hosted)
0 0 * * * /usr/bin/wget https://your.app/keys.php?source=gitlab&username=yourusername&host=yourinstancehost" -O ~/.ssh/authorized_keys && chmod 0600 ~/.ssh/authorized_keys
```

The formatter already returns a `Content-Type: text/plain` response.

# Supported Sources

* GitHub
    * `source` - this should be set to `github`
    * `username` - your GitHub username
* GitLab
    * `source` - this should be set to `gitlab`
    * `username` - your GitLab username
    * `host` - (optional) if you are on a self-hosted service (and not on `gitlab.com`, specify your host)
    
# License

This free script is licensed under the [WTFPL](http://www.wtfpl.net/about/) license.

```
            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 2, December 2004

 Copyright (C) 2020 Liam Demafelix <hey@liam.ph>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.
```