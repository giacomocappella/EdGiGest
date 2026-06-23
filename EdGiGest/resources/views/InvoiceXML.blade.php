{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}<ns2:FatturaElettronica versione="FPR12" xmlns:ns2="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2">
<FatturaElettronicaHeader>
<DatiTrasmissione>
	<IdTrasmittente>
		<IdPaese>IT</IdPaese>
		<IdCodice>{{ $tech->CF }}</IdCodice>
	</IdTrasmittente>
	<ProgressivoInvio>{{ $invoice->progressivo_invio }}</ProgressivoInvio>
	<FormatoTrasmissione>FPR12</FormatoTrasmissione>
	<CodiceDestinatario>{{ $client->Cod_destinatario }}</CodiceDestinatario>
</DatiTrasmissione>
<CedentePrestatore>
	<DatiAnagrafici>
		<IdFiscaleIVA>
			<IdPaese>IT</IdPaese>
			<IdCodice>{{ $tech->Partita_Iva }}</IdCodice>
		</IdFiscaleIVA>
		<CodiceFiscale>{{ $tech->CF }}</CodiceFiscale>
		<Anagrafica>
			<Nome>{{ $nome }}</Nome>
			<Cognome>{{ $nome }}</Cognome>
		</Anagrafica>
	<RegimeFiscale>RF19</RegimeFiscale>
	</DatiAnagrafici>
	<Sede>
		<Indirizzo>{{ $tech->Via }}</Indirizzo>
		<NumeroCivico>{{ $tech->Civico }}</NumeroCivico>
		<CAP>{{ $tech->CAP }}</CAP>
		<Comune>{{ $tech->Citta }}</Comune>
		<Provincia>{{ $tech->Provincia }}</Provincia>
		<Nazione>IT</Nazione>
	</Sede>
</CedentePrestatore>
<CessionarioCommittente>
	<DatiAnagrafici>
		<IdFiscaleIVA>
			<IdPaese>IT</IdPaese>
			<IdCodice>{{$client->Partita_IVA_CF}}</IdCodice>
		</IdFiscaleIVA>
		<CodiceFiscale>{{$client->Codice_Fiscale}}</CodiceFiscale>
		<Anagrafica>
			<Denominazione>{{$client->Ragione_Sociale}}</Denominazione>
		</Anagrafica>
	</DatiAnagrafici>
	<Sede>
		<Indirizzo>{{$client->Via}}</Indirizzo>
		<NumeroCivico>{{$client->Civico}}</NumeroCivico>
		<CAP>{{$client->Cap}}</CAP>
		<Comune>{{$client->Citta}}</Comune>
		<Provincia>{{$client->Provincia}}</Provincia>
		<Nazione>IT</Nazione>
	</Sede>
</CessionarioCommittente>
</FatturaElettronicaHeader>
<FatturaElettronicaBody>
<DatiGenerali>
	<DatiGeneraliDocumento>
		<TipoDocumento>{{ $invoice->tipo_documento }}</TipoDocumento>
		<Divisa>EUR</Divisa>
		<Data>{{ $invoice->data_emissione }}</Data>
		<Numero>{{ $invoice->numero }}</Numero>
		<DatiBollo>
			<BolloVirtuale>SI</BolloVirtuale>
			<ImportoBollo>2.00</ImportoBollo>
		</DatiBollo>
		<ImportoTotaleDocumento>{{ number_format($invoice->importo_totale, 2, '.', '') }}</ImportoTotaleDocumento>
		<Causale>OPERAZIONE SENZA APPLICAZIONE DELL'IVA AI SENSI art.1, c. 58, L. n.190/2014. - OPERAZIONE SENZA APPLICAZIONE DELLA RITENUTA ALLA FONTE A TITOLO D'ACCONTO.</Causale>
	</DatiGeneraliDocumento>
</DatiGenerali>
<DatiBeniServizi>
	<DettaglioLinee>
		<NumeroLinea>1</NumeroLinea>
		<Descrizione>Prestazioni di Consulenza Informatica</Descrizione>
        <PrezzoUnitario>{{ number_format($invoice->prezzo_totale, 2,'.', '') }}</PrezzoUnitario>
		<PrezzoTotale>{{ number_format($invoice->prezzo_totale, 2, '.', '') }}</PrezzoTotale>
		<AliquotaIVA>0.00</AliquotaIVA>
		<Natura>{{ $invoice->natura }}</Natura>
	</DettaglioLinee>
    <DettaglioLinee>
		<NumeroLinea>2</NumeroLinea>
		<Descrizione>Rivalsa contributo INPS 4%</Descrizione>
        <PrezzoUnitario>{{ number_format($invoice->importo_totale - $invoice->prezzo_totale, 2, '.', '') }}</PrezzoUnitario>
		<PrezzoTotale>{{ number_format($invoice->importo_totale - $invoice->prezzo_totale, 2, '.', '') }}</PrezzoTotale>
		<AliquotaIVA>0.00</AliquotaIVA>
		<Natura>{{ $invoice->natura }}</Natura>
	</DettaglioLinee>
<DatiRiepilogo>
	<AliquotaIVA>{{ $invoice->aliquota_iva }}</AliquotaIVA>
	<Natura>N2.2</Natura>
	<ImponibileImporto>{{ number_format($invoice->prezzo_totale, 2, '.', '') }}</ImponibileImporto>
	<Imposta>{{ $invoice->aliquota_iva }}</Imposta>
	<RiferimentoNormativo>Operazione senza applicazione dell'IVA ai sensi dell'art.1 comma 58 Legge n.190/2014.</RiferimentoNormativo>
</DatiRiepilogo>
</DatiBeniServizi>
<DatiPagamento>
<CondizioniPagamento>TP02</CondizioniPagamento>
<DettaglioPagamento>
	<ModalitaPagamento>{{ $invoice->modalita_pagamento }}</ModalitaPagamento>
	<DataRiferimentoTerminiPagamento>{{ $invoice->data_scadenza }}</DataRiferimentoTerminiPagamento>
	<ImportoPagamento>{{ number_format($invoice->importo_totale, 2, '.', '') }}</ImportoPagamento>
	<IBAN>{{ $tech->iban }}</IBAN></DettaglioPagamento>
</DatiPagamento>
</FatturaElettronicaBody>
</ns2:FatturaElettronica>
