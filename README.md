TS3Viewer
=========

Bundle to implement TS3 Viewer into SF2

# Install via composer

```json
"seyon/teamspeak3-viewer-bundle": "v1.0.0"
```

# Usage (normal)

add this into your twig Template

```twig
...
{{ render(controller('SeyonTeamspeak3ViewerBundle:View:overview')) }}
...
```

# config

```yaml
seyon_teamspeak3_viewer:
    user: xxxx
    pass: yyyy
    host: your.server.ts
    query: 10011
    voice: 9987
```



# Usage (hinclude.js)

```twig
...
{{ render_hinclude(controller('SeyonTeamspeak3ViewerBundle:View:overview')) }}
...
```

# config

```yaml
framework:
    ....
    fragments: { path: /_fragment }

seyon_teamspeak3_viewer:
    user: xxxx
    pass: yyyy
    host: your.server.ts
    query: 10011
    voice: 9987
```