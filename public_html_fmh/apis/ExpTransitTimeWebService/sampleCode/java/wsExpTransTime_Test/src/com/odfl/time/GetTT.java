//
// Generated By:JAX-WS RI IBM 2.2.1-11/30/2010 12:42 PM(foreman)- (JAXB RI IBM 2.2.1-12/20/2010 05:40 PM(foreman)-)
//


package com.odfl.time;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for getTT complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="getTT">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="arg0" type="{http://time.odfl.com/}timeRequest" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "getTT", propOrder = {
    "arg0"
})
public class GetTT {

    protected TimeRequest arg0;

    /**
     * Gets the value of the arg0 property.
     * 
     * @return
     *     possible object is
     *     {@link TimeRequest }
     *     
     */
    public TimeRequest getArg0() {
        return arg0;
    }

    /**
     * Sets the value of the arg0 property.
     * 
     * @param value
     *     allowed object is
     *     {@link TimeRequest }
     *     
     */
    public void setArg0(TimeRequest value) {
        this.arg0 = value;
    }

}
