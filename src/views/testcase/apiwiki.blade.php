{{ $title }}
---


REQUEST : **{{ $method }} {{ $url }}**
@if (!empty($code_request))
```
{{ $code_request }}
```
@endif

RESPONSE : **{{ $status_code }} {{ $status }}**
```
{{ $code_response }}
```

