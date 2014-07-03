from src.Parallelbug import Parallelbug
import os

Parallelbug.dir = os.path.join(os.getcwd(), "logs")

Parallelbug.dump([
	"foo"
], {
	"filename": "array"
})

Parallelbug.dump({
	"foo": "bar"
}, {
	"filename": "dict"
})

Parallelbug.dump(True, {
	"filename": "true"
})

Parallelbug.dump(False, {
	"filename": "false"
})

Parallelbug.dump(1.456, {
	"filename": "float"
})

Parallelbug.dump({
	"foo": "bar"
}, {
	"filename": "append"
})

Parallelbug.dump({
	"foo": "bar"
}, {
	"filename": "append",
	"append": True
})
Parallelbug.dump({
	"foo2": "bar2"
}, {
	"filename": "append",
	"append": True
})