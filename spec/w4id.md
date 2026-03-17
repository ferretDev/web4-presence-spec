# W4ID — Web4 Identity Identifier

**Version: 0.1 Draft**  
**Date: March 17, 2026**

## Overview

A W4ID is a persistent business identity 
independent of any domain.
```
W4-CA-2026-A7K9M-42

W4      Web4 identifier prefix
CA      ISO 3166 country code
2026    Year of registration
A7K9M   Unique identifier (base36)
42      Checksum digits
```

## Why W4ID

Domain-based identity is fragile.
Domains expire. Businesses rebrand.
Hosting changes. Platforms disappear.

A W4ID survives all of these.
It is the anchor that makes 
business identity portable.

## Usage in presence.w4
```json
{
  "identity:w4id": "W4-CA-2026-A7K9M-42",
  "identity:name": "Joe's Plumbing",
  "identity:canonical": "joesplumbing.ca"
}
```

## Verification

DNS TXT record on claiming domain:
```
TXT "w4id=W4-CA-2026-A7K9M-42"
```

Agent verification:
1. Reads W4ID from presence.w4
2. DNS TXT lookup on domain
3. Confirms domain claims this W4ID
4. Checks registry for W4ID record
5. Identity verified

## Trust Levels
```
Level 0  Self declared — no verification
Level 1  Domain verified — DNS TXT confirmed
Level 2  Business verified — registry confirmed
Level 3  Professional verified — licence confirmed
Level 4  Government verified — full confirmation
```

## Registry

W4ID registration and registry:
w4id.dev

## License

MIT — open forever
