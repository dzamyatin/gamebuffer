Every 10 seconds command are comparing games with buffers games and associate it
```
gamebuffer:process
```

Add game to buffer

```
curl -X POST \
  http://127.0.0.1:9123/gamebuffer \
  -d '{
	"language": "en",
	"league": "league",
	"sport": "footboll",
	"teamOne": "Real",
	"teamTwo": "Barcelna",
	"datetime": "2019-10-12T20:35:38+0000",
	"source": "source"
}'
```

Batch add

```
curl -X POST \
  http://127.0.0.1:9123/gamebuffer \
  -d '[{
	"language": "en",
	"league": "league",
	"sport": "footboll",
	"teamOne": "Real",
	"teamTwo": "Barcelna",
	"datetime": "2019-10-12T20:35:38+0000",
	"source": "source"
},
{
	"language": "en",
	"league": "league",
	"sport": "footboll",
	"teamOne": "Real",
	"teamTwo": "Barcelna",
	"datetime": "2019-10-12T20:35:38+0000",
	"source": "source"
}]'
```